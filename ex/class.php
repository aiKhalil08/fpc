<?php
//session_start();
echo $_COOKIE['name'];
class Sess {
	public function dos() {
		$_SESSION['some'] = array('read', 'bluye', 'green');
	}
}
?>