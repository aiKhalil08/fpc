<?php
class CustomException extends Exception {
	private $backtrace;
	public function __construct($backtrace = '', $message = false, $code = 0) {
		$this->backtrace = $backtrace;
		$this->message = $message;
		$this->code = $code;
	}
	public function getBackTrace() {
		return $this->backtrace;
	}
}
class HandleError {
	public function createBackTrace($array) {
		//$index = count($array) - 1;
		for ($i = 0; $i < count($array); $i++) {
			//$backtraceArray[$i] = $array[$i];
			foreach ($array[$i] as $item => $value) {
				if ($item == 'file') {
					$backtraceArray[$i]['file'] = $value;
				} else if ($item == 'line') {
					$backtraceArray[$i]['line'] = $value;
				} else if ($item == 'function') {
					$backtraceArray[$i]['function'] = $value;
				}
			}
		}
		return $backtraceArray;
	}
	public function createErrorString($array, $string) {
		$time = date('H:i:s');
		$backtraceString = '';
		for ($i = 0; $i < sizeof($array); $i++) {
			$bulletNumber = $i + 1;
			$backtraceString .=  '{'.$bulletNumber.': ';
			foreach ($array[$i] as $key => $value) {
				$backtraceString .= $key.' = '.$value.'; ';
			}
			$backtraceString .= '}';
		}
		$errorString = '- '.$string.' ['.$backtraceString.' '.$time.']'."\n";
		return $errorString;
	}
	public function logErrorString($string) {
		$dir = opendir(getcwd());
		$file = readdir($dir);
		$file = readdir($dir);
		while ($file = readdir($dir)) {
			$files[] = $file;
		}
		$errorFile = '../bin/errorlog.txt';
		file_put_contents($errorFile, $string, FILE_APPEND);
	}
	public function redirect($url) {
		header('location: '.$url);		
	}
}
function handle_exception_obj($object, $redr = false, $url = false) {
	$errorInstance = new HandleError;
	$backtraceArray = $errorInstance->createBackTrace($object->getBackTrace());
	$errorMessage = $object->getMessage();
	$errorString = $errorInstance->createErrorString($backtraceArray,$errorMessage);
	$errorInstance->logErrorString($errorString);
	if ($redr) {
		$errorInstance->redirect($url);
	}
} 
function default_exception_handler($exception) {
	$error = new HandleError;
	$backtrace = $error->createBackTrace($exception->getBackTrace());
	$string = $error->createErrorString($backtrace, $exception->getMessage());
	$error->logErrorString($string);
	switch ($exception) {
	 	case is_a($exception, 'CustomException'):
	 		header('location: ./quiz/quiz.php');
	 		break;
	 	case is_a($exception, 'DumException'):
	 		header('location: ./frees.php');
	 		break;
	 	default:
	 		// code...
	 		break;
	 } 
}
function handle_session_errors() {
	if ($_SESSION) {
		foreach ($_SESSION as $key) {
			if (is_array($key)) {
				for ($i = 0; $i < sizeof($key); $i++) { 
					echo '<div class=\'login_errors\'>'.@$key[$i].'</div>';
				}
			} else {
				echo '<div class=\'login_errors\'>'.@$key.'</div>';
			}
		}
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
	}
}
?>