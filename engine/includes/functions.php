<?php
require_once(__DIR__.'/../require.php');
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