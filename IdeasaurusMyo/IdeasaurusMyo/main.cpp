#define _USE_MATH_DEFINES
#include <cmath>
#include <iostream>
#include <iomanip>
#include <stdexcept>
#include <string>

#include <Windows.h>

#include <myo/myo.hpp>

class DataCollector : public myo::DeviceListener
{
public:
	DataCollector() : onArm(false), roll_w(0), pitch_w(0), yaw_w(0), currentPose() { }

	void onUnpair(myo::Myo *myo, uint64_t timestamp)
	{
		roll_w = 0;
		pitch_w = 0;
		yaw_w = 0;
		onArm = false;
	}

	//Called whenever the Myo device provides it's current orientation data
	void onOrientationData(myo::Myo *myo, uint64_t timestamp, const myo::Quaternion<float> &quat)
	{
		using std::atan2;
		using std::asin;
		using std::sqrt;

		// Calculate Euler angles (roll, pitch, and yaw) from the unit quaternion.
        float roll = atan2(2.0f * (quat.w() * quat.x() + quat.y() * quat.z()),
                           1.0f - 2.0f * (quat.x() * quat.x() + quat.y() * quat.y()));
        float pitch = asin(2.0f * (quat.w() * quat.y() - quat.z() * quat.x()));
        float yaw = atan2(2.0f * (quat.w() * quat.z() + quat.x() * quat.y()),
                        1.0f - 2.0f * (quat.y() * quat.y() + quat.z() * quat.z()));
        // Convert the floating point angles in radians to a scale from 0 to 20.
        roll_w = static_cast<int>((roll + (float)M_PI)/(M_PI * 2.0f) * 18);
        pitch_w = static_cast<int>((pitch + (float)M_PI/2.0f)/M_PI * 18);
        yaw_w = static_cast<int>((yaw + (float)M_PI)/(M_PI * 2.0f) * 18);
	}

	void onPose(myo::Myo *myo, uint64_t timestamp, myo::Pose pose)
	{
		currentPose = pose;

		if(pose == myo::Pose::waveIn)
		{
			myo->vibrate(myo::Myo::vibrationShort);
			INPUT input = { 0 };
			input.type = INPUT_MOUSE;
			input.mi.dwFlags = MOUSEEVENTF_LEFTDOWN;
			SendInput(1, &input, sizeof(INPUT));
			ZeroMemory(&input, sizeof(INPUT));
			input.type = INPUT_MOUSE;
			input.mi.dwFlags = MOUSEEVENTF_LEFTUP;
			SendInput(1, &input, sizeof(INPUT));
		}
		else if(pose == myo::Pose::waveOut)
		{
			myo->vibrate(myo::Myo::vibrationShort);
			INPUT input = { 0 };
			input.type = INPUT_MOUSE;
			input.mi.dwFlags = MOUSEEVENTF_RIGHTDOWN;
			SendInput(1, &input, sizeof(INPUT));
			ZeroMemory(&input, sizeof(INPUT));
			input.type = INPUT_MOUSE;
			input.mi.dwFlags = MOUSEEVENTF_RIGHTUP;
			SendInput(1, &input, sizeof(INPUT));
		}
	}

	//Called whenever Myo has recognized a setup gesture after someone has put it on their arm
	void onArmRecognized(myo::Myo *myo, uint64_t timestamp, myo::Arm arm, myo::XDirection xDirection)
	{
		onArm = true;
		whichArm = arm;
	}

	void onArmLost(myo::Myo *myo, uint64_t timestamp)
	{
		onArm = false;
	}

	void print()
    {
        // Clear the current line
        std::cout << '\r';
        // Print out the orientation. Orientation data is always available, even if no arm is currently recognized.
        std::cout << '[' << std::string(roll_w, '*') << std::string(18 - roll_w, ' ') << ']'
                  << '[' << std::string(pitch_w, '*') << std::string(18 - pitch_w, ' ') << ']'
                  << '[' << std::string(yaw_w, '*') << std::string(18 - yaw_w, ' ') << ']';
        if (onArm) {
            // Print out the currently recognized pose and which arm Myo is being worn on.
            // Pose::toString() provides the human-readable name of a pose. We can also output a Pose directly to an
            // output stream (e.g. std::cout << currentPose;). In this case we want to get the pose name's length so
            // that we can fill the rest of the field with spaces below, so we obtain it as a string using toString().
            std::string poseString = currentPose.toString();
            std::cout << '[' << (whichArm == myo::armLeft ? "L" : "R") << ']'
                      << '[' << poseString << std::string(14 - poseString.size(), ' ') << ']';
        } else {
            // Print out a placeholder for the arm and pose when Myo doesn't currently know which arm it's on.
            std::cout << "[?]" << '[' << std::string(14, ' ') << ']';
        }
        std::cout << std::flush;
    }
    // These values are set by onArmRecognized() and onArmLost() above.
    bool onArm;
    myo::Arm whichArm;
    // These values are set by onOrientationData() and onPose() above.
    int roll_w, pitch_w, yaw_w;
    myo::Pose currentPose;
};

int main(int argc, char **argv)
{
	try
	{
		myo::Hub hub("com.example.hello-myo");

		std::cout << "Attempting to find a Myo..." << std::endl;

		//Attempt to find a Myo for use
		myo::Myo *myo = hub.waitForMyo(10000);

		if(!myo)
		{
			throw std::runtime_error("Unable to find a Myo!");
		}

		std::cout << "Connected to a Myo armband!" << std::endl << std::endl;

		DataCollector collector;

		hub.addListener(&collector);

		while(true)
		{
			hub.run(1000/20);
			collector.print();
		}
	}
	catch(const std::exception &e)
	{
		std::cerr << "Error: " << e.what() << std::endl;
		std::cerr << "Press enter to continue.";
		std::cin.ignore();
		return 1;
	}
}