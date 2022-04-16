<?php
if (!isset($_SESSION)) {
	session_start();
}
function check_login($index, $redir_location) {
	if (!$_COOKIE[$index]) {
		header('location: '.$redir_location);
	}
}
?>