<pre>
<?php 

$district='wayanad';
if(isset($_GET['q'])){
		$district=$_GET['q'];
}
$var=file_get_contents('http://www.imd.gov.in/section/nhac/distforecast/'.$district.'.htm');

// parse one
preg_match_all("/\s+(\d)+\s+(\d)+\s+(\d)+\s+(\d)+\s+(\d)+/",$var, $phones);
foreach($phones[0] as $one){
		$ones[]=separate($one);
};

function separate($string){
	preg_match_all("/\s{3}+\d+/",$string, $ones);
	return $ones;
}

$names=array('Rainfall (mm)','Max Temperature ( deg C)','Min Temperature ( deg C)','Total cloud cover (octa)','Max Relative Humidity (%)','Min Relative Humidity (%)','Wind speed (kmph)','Wind direction (deg)');
$count=0;

function showall($ones){
	foreach($ones as $o){
		print $names[$count].'<br/>';
		foreach($o[0] as $t){
			print '|'.$t;
		}
		print '<hr/>';
		$count++;
	}
}


//print 'Rainfall';
show_particular($ones,1,$names[1],1);
show_particular($ones,2,$names[2],2);

//print 'Rainfall';

function show_particular($ones,$index,$names,$va=1){
	print '\''.$names.'\' : {'.$ones[$va][0][0].'}';
}
?>