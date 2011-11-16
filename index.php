<div style="background-color:blue; padding:30px; color:yellow">
<pre>
<?php 

/** 
	table titles from IMD
 **/

function names($v=false){
	$names=array('rainfall'=>'Rainfall (mm)',
			'max-temp'=>'Max Temperature ( deg C)',
			'min-temp'=>'Min Temperature ( deg C)',
			'total-cloud-cover'=>'Total cloud cover (octa)',
			'max-rel-hum'=>'Max Relative Humidity (%)',
			'mind-rel-hum'=>'Min Relative Humidity (%)',
			'wind-speed'=>'Wind speed (kmph)',
			'wind-dir'=>'Wind direction (deg)',
			);
	if($v){
	$i=0;
	foreach ($names as $key=>$value){
		$yoyo[$key]=array(
						'id'=>$i,
						'value'=>$key,
						'title'=>$value,
					);
		$i++;
	}
	
	return $yoyo;
	}else{
		return $names;
	}

}
	$count=0;

function get_name(){
	/** default city **/
	$district='kozhikode';
	if(isset($_GET['q'])){
		$district=$_GET['q'];
	}
	$dist=$district;
	return $dist;
}

function get_city_data($dist){
	if(!$dist)
		return ;
	$source=source($dist);
	$var=file_get_contents($source);

	// parse one
	preg_match_all("/\s+(\d)+\s+(\d)+\s+(\d)+\s+(\d)+\s+(\d)+/",$var, $phones);
	foreach($phones[0] as $one){
		$ones[]=separate($one);
	};
	
	return $ones;
		
}


/** silly migration stuffs, you know **/


function source($dist){
	return 'http://www.imd.gov.in/section/nhac/distforecast/'.$dist.'.htm';
}
$source=source($dist);
/** ends **/

function separate($string){
	preg_match_all("/\s{3}+\d+/",$string, $ones);
	return $ones;
}

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

function look_up($day=1,$results=array()){
	
}

function show_particular($name=null,$index='max-temp',$day=0){

	$name=get_name();	
	$ones=get_city_data($name);
	// get data titles
	
	if(is_array($index)){
		foreach($index as $m){
			print loo($m,$ones,$day);
		}

	}
	
}

function loo($index,$ones,$day=1){
	$names=names(true);
	// title, id
	$title=$names[$index]['title'];	
	$id=$names[$index]['id'];
	$to= $ones;
	$value=$to[$id][0][$day];
	return $title.' : '.$value.'<br/>';
}


//print 'Rainfall';
show_particular(null,array('max-temp','min-temp','wind-dir'),2);


?>
</div>