<?php
session_start();
require './class.php';
$obj = new Sess;
$obj->dos();
unset($_SESSION['some']);
//$_SESSION['des'] = 'wtf';
echo $_COOKIE['name'];
?>