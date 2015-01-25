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

function fatal($msg, $error, $file='info'){
	log_error($error, $file, 'fatal error');
	die("Fatal error: <b>$msg</b><br>\n(we hope, you're trying to cheat)");
}
function log_error($error, $file='info', $section='error', $debug=null){
	if ($debug===null){
		$debug=debug_backtrace();
		//unset($debug[0]['file']);
		unset($debug[0]['args']);
	}
	log_info($error, $section, $file, $debug);
}
function log_warning($warning, $file='info', $section='warning', $debug=null){
	if ($debug===null){
		$debug=debug_backtrace();
		//unset($debug[0]['file']);
		unset($debug[0]['args']);
	}
	log_info($warning, $section, $file, $debug);
}
function dbg($info, $file='info', $section='debug'){
	$info=print_r($info, true);
	$debug=debug_backtrace();
	//unset($debug[0]['file']);
	unset($debug[0]['args']);
	log_info($info, $section, $file, $debug);
}
function log_info($info, $sect='info', $file='info', $debug=null){
	/*
	global $con;
	if (is_array($info)){
		$info=print_r($info, true);
	}
	$info=addslashes($info);
	if ($debug===null){
		$debug="null";
	} else {
		$debug="'".addslashes(print_r($debug, true))."'";
	}
	$info=addslashes($info);
	$ques="INSERT INTO log (file, section, info, debug) VALUES ('$file', '$sect', '$info', $debug)";
	$con->query($ques);
	if ($con->errno){
		file_put_contents('fatal_error_log', date("r")." [log_error]Query failed: $ques");
	}
	*/
	if (isset($_GET['dev'])){
		echo "<div class=log>\n";
			echo "<b>$file</b>[$sect] $info<br>\n";
			echo "<pre>\n";
				var_dump($debug);echo "\n";
			echo "</pre>\n";
		echo "</div>\n";
	}
}
?>