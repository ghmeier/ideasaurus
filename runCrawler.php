<?php 
#echo 'hello';

#echo system('/bin/ruby /var/www/html/tryTwo/webCrawler.rb');

$search = $_POST["search"];
$depth = $_POST['depth'];
$results = $_POST['results'];


$t='<p><b>Hello</b><i>world!</i></p>';
$scaped=preg_quote($t,"/");
$program='ruby webCrawler.rb -s '.$search.' -d '.$depth.' -r '.$results.'';
#$program='ruby webCrawler.rb -s Light -d 10 -r 10';


//exec($program.' '.$scaped,$n); print_r($n); exit; //Works!!!

$input=$t;

$descriptorspec=array(
   array('pipe','r'),//stdin is a pipe that the child will read from
   array('pipe','w'),//stdout is a pipe that the child will write to
   array('file','./error-output.txt','a')//stderr is a file to write to
);

$process=proc_open($program,$descriptorspec,$pipes);
if(is_resource($process)){
    fwrite($pipes[0],$input);
    fclose($pipes[0]);
    $r=stream_get_contents($pipes[1]);
    fclose($pipes[1]);
    $return_value=proc_close($process);
	parse_str($r,$array);

	print_r(http_build_query($array));
}


?>
