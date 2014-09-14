require 'spidr'
require "optparse"  

options = {:search => "Dinosaur", :depth => 0, :results => 5}

#parse command line options for admin
parser = OptionParser.new {|opt|
  opt.on("-s","--search <name>","Search terms"){ |u|
    options[:search]= u
  }
  opt.on("-d","--depth <password>","Search Depth"){|p|
    options[:password] = p
    }
  
  opt.on("-r","--results <key>","number of results"){ |a|
    options[:results] = a
    }
    
}

parser.parse!

$extHash = Hash.new(0)

$ignoreUrls = ["http://en.wikipedia.org/wiki/Digital_object_identifier",
			"http://en.wikipedia.org/wiki/PubMed_Identifier",
			"http://en.wikipedia.org/wiki/International_Standard_Book_Number",
			"http://en.wikipedia.org/wiki/Main_Page",
			"http://en.wikipedia.org/wiki/PubMed_Central"
			]
			
terms = "#{options[:search]}"
terms.capitalize!
url = "http://en.wikipedia.org/wiki/#{terms}"
Spidr.start_at("http://en.wikipedia.org/wiki/#{terms}", :max_depth => options[:depth].to_i) { |spider|

	regex = "http://en.wikipedia.org/wiki/(?!([^:]+)[:])"
	ignore = "http://en.wikipedia.org/wiki/([^:]+)[:]"
		spider.visit_links_like(/#{regex}/){|link|
			spider.levels.include?(URI(link))
		}
		
		spider.every_link{ |origin, dest|
			if 	$ignoreUrls.include?("#{dest}") #|| spider.levels.include?(dest)
				next
			end

			if /#{regex}/ .match("#{dest}")
			splitPath = dest.path.split('/')
			#puts splitPath[splitPath.length-1]
				if $extHash[splitPath[splitPath.length-1]] == nil
					$extHash[splitPath[splitPath.length-1]] = 1
				else 
					$extHash[splitPath[splitPath.length-1]] += 1
				end
				#puts spider.levels.length
				#puts "#{splitPath[splitPath.length-1]} => #{$extHash[splitPath[splitPath.length-1]]}"
			end 
		}
}

goTo = -1
if options[:results].to_i < $extHash.length.to_i
	goTo = options[:results].to_i
end

finalResults = Hash.new()

Hash[Array($extHash.sort{|a,b|  a[1] <=> b[1]}.reverse!)[0..goTo]].each_pair{ |key,value|
	finalResults[key] = value
	}
uri = URI("http://www.wikipedia.com/")
final = URI.encode_www_form(finalResults)
#output = File.open("dummyfile.txt","w")
#output << final
#output.close
puts final
