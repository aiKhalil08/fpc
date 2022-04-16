<?php
session_start();
//echo $_SESSION['some'].' hahah';
//echo 'what is jhal '.$_SESSION['des'];
//unset($_SESSION['some']);
//var_dump($_SESSION);
//var_dump($_COOKIE);
//echo $_COOKIE['admin_username'];//
//setcookie('name', 'jide', 0, '/');
if (preg_match('/[^a-z]/i', 'zudA')) {
	echo 'has numbers';
}
?>