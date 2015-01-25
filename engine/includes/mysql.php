<?php
//echo "NEW FILE";
include_once 'include_all.php';
$con=new mysqli('localhost','elementi',pw,'elementi_chicken');

if(!true)set_error_handler('errorHandler');
function errorHandler($errno, $errmsg, $filename, $linenum, $vars) // (C) PHP.net
{
	/*
	$errortype = array (
		E_ERROR              => 'Error',
		E_WARNING            => 'Warning',
		E_PARSE              => 'Parsing Error',
		E_NOTICE             => 'Notice',
		E_CORE_ERROR         => 'Core Error',
		E_CORE_WARNING       => 'Core Warning',
		E_COMPILE_ERROR      => 'Compile Error',
		E_COMPILE_WARNING    => 'Compile Warning',
		E_USER_ERROR         => 'User Error',
		E_USER_WARNING       => 'User Warning',
		E_USER_NOTICE        => 'User Notice',
		E_STRICT             => 'Runtime Notice',
		E_RECOVERABLE_ERROR  => 'Catchable Fatal Error'
	);
	*/
	$errortype=[
		E_ERROR			=>'E_ERROR',
		E_WARNING		=>'E_WARNING',
		E_PARSE			=>'E_PARSE',
		E_NOTICE		=>'E_NOTICE',
		E_CORE_ERROR		=>'E_CORE_ERROR',
		E_CORE_WARNING		=>'E_CORE_WARNING',
		E_COMPILE_ERROR		=>'E_COMPILE_ERROR',
		E_COMPILE_WARNING	=>'E_COMPILE_WARNING',
		E_USER_ERROR		=>'E_USER_ERROR',
		E_USER_WARNING		=>'E_USER_WARNING',
		E_USER_NOTICE		=>'E_USER_NOTICE',
		E_STRICT		=>'E_STRICT',
		E_RECOVERABLE_ERROR	=>'E_RECOVERABLE_ERROR'
	];
	// set of errors for which a var trace will be saved
	$user_errors=array(
		E_USER_ERROR,
		E_USER_WARNING,
		E_USER_NOTICE
	);
	
	$debug['file']=$filename;
	$debug['line']=$linenum;
	$debug['vars']=$vars;
	/*
	$bactrace=debug_backtrace();
	$bactrace=isset($backtrace)?$backtrace:false;
	if(is_array($backtrace)) unset($bactrace[0]);
	$debug['backtrace']=$backtrace;
	*/
	
	// save to the error log, and e-mail me if there is a critical user error
	log_error($errmsg, 'auto-reported', $errortype[$errno], $debug);
	if ($errno == E_USER_ERROR) {
		mail("phpdev@example.com", "Critical User Error", print_r([$errno, $errmsg, $filename, $linenum, $vars], true));
	}
}

class unloaded{
	public $type='';
	public $types=[];
	public $possibletypes=[
		'array'=>'basic',
		'id'=>'numeric',
		'comment'=>'basic',
		'base'=>'object',
		'party'=>'object',
		'group'=>'object',
		'user'=>'object',
		'place'=>'object'
	];
	
	private function checktype($needle, &$haystack){
		$len=strlen($needle);
		if (substr($haystack, 0, $len)==$needle){
			$haystack=substr($haystack, $len+1);
			return true;
		}else return false;
	}
	
	private function getarr($type){
		if (in_array($type, $this->possibletypes)){
			return [$type=>getarr($possibletypes[$type])];
		}else return 'boolean';
	}
	
	public function create($type){
		$this->type=$type;
		while ($type){
			foreach($this->possibletypes as $key=>$value){
				if($this->checktype($key, $type)){
					$this->types[]=getarr($type);
				}
			}
		}
		dbg("empty($type)==".print_r($this, true));
	}
	
	public function canfill($value){
		if(in_array($value, $this->types, true)){
			//$this=$value;
			return true;
		}else return false;
	}
}

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
	if (isset($GLOBALS['class'])){
		$class=$GLOBALS['class'];
		$inputs['current']=get_class($class);
		//$inputs['class']=(string)$class;
	}
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
	die("Fatal error: $msg<br>\n(we hope, you're trying to cheat)");
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
}

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