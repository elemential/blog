<?php
//echo "NEW FILE";
include_once 'motor.php';
$con=&$ab;

$sqlid=null;
//$nothig=GENERATE_ERROR;
function calcQues($ques, $inputs){
	$arrtostr=function($input){
					$return=[];
					foreach ($input as $key=>$value){
						$return[$key]=calcQues('%1', [1=>$value]);
					}
					return implode(', ', $return);
				};
	foreach ($inputs as $key=>$input){
		$inserts=[];
		if (is_numeric($input)){
			$inserts[]=[
				'insert'=>(int)$input,
				'signs'=>['%', '#']
			];
		}
		if (is_bool($input)) {
			$inserts[]=[
				'insert'=>$input?1:0,
				'signs'=>['%', '?']
			];
		}
		if (is_null($input)) {
			$inserts[]=[
				'insert'=>'NULL',
				'signs'=>['%', '#', '?', '@']
			];
		}
		if (is_string($input)){
			$inserts[]=[
				'insert'=>"'".addslashes($input)."'",
				'signs'=>['%', '@']
			];
		}
		if (is_array($input)) {
			$inserts[]=[
				'insert'=>"'".addslashes(print_r($input, true))."'",
				'signs'=>['%', '@', '/']
			];
			$inserts[]=[
				'insert'=>implode(', ', array_keys($input)),
				'signs'=>['[keys]']
			];
			$inserts[]=[
				'insert'=>$arrtostr($input),
				'signs'=>['[values]', '[]']
			];
		}
		if (true){
			$inserts[]=[
				'insert'=>$input,
				'signs'=>['&']
			];
		}
		
		foreach ($inserts as $insertarr){
			$insert=$insertarr['insert'];
			if (isset($insertarr['signs'])){
				foreach($insertarr['signs'] as $sign){
					$ques=str_replace($sign.$key, $insert, $ques);
				}
			} else {
				$ques=str_replace($insertarr['key'], $insert, $ques);
			}
		}
	}
	return $ques;
}
function query(){
	global $con, $sqlid;
	sleep(1);
	$inputs=func_get_args();
	$ques=$inputs[0];
	unset($inputs[0]);
	//log_info(print_r($inputs, true), 'info', 'mysql', debug_backtrace());
	/*
	if (isset($GLOBALS['class'])){
		$class=$GLOBALS['class'];
		$inputs['current']=get_class($class);
		//$inputs['class']=(string)$class;
	}
	*/
	$ques=calcQues($ques, $inputs);
	log_ques($ques);
	$lsqlid=sqlid(true, false);
	$result=$con->query($ques);
	$sqlid=sqlid(true, false);
	if ($sqlid==$lsqlid){
		$sqlid=null;
	}
	if (!$result) {
		log_mysql_error($con->error);
	}
	return $result;
}
function sqlid($real=false, $log=true){ //returns mysql's insert_id
	global $con, $sqlid;
	$return=$real?$con->insert_id:$sqlid;
	if ($log){
		log_mysql($return, 'insert_id');
	}
	return $return;
}
function log_ques($ques){
	if (!$ques) $ques=$GLOBALS['ques']; //ques=query string
	log_mysql($ques, "query");
}
function log_mysql_error($error){
	if (!$error) $error=$GLOBALS['con']->error;
	log_error($error, 'mysql');
}
function log_mysql($info, $sect='info'){
	log_info($info, $sect, 'mysql');
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