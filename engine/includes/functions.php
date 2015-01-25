<?php
include_once('local.php');
include_once('mysql.php');
require('engine/classes/poszt.class.php');
require('engine/classes/komment.class.php');
require('engine/classes/cimke.class.php');

function toarray($keys=[], $that=null, $details=false){
	if ($that && !$details) $details=$that->details; 
	$thats=function($key)use($that, $details){
		if ($that!=null){
			return $that->$key;
		}
		else{
			if($key=='details') {
				return $details;
			}else{
				return $details[$key];
			}
		}
	};
	$result=[];
	if ($keys===true){
		return $details;
	}
	
	foreach ($keys as $key=>$value){
		if (!$value){
			//DoNothing();
		}elseif (is_array($details[$key])){
			$result[key]=toarray($value, null, $details[$key]);
		}elseif(is_object($details[$key])){
			$result[$key]=$details[$key];
		}else{
			if ($value) $result[$key]=$thats($key);
		}
	}
	
	return $result;
}
?>