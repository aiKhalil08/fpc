<?php
require '../bin/page_view.php';
require '../bin/contr.php';
if (!$_REQUEST) header('location: ./login.php');
var_dump($_POST);
$username = $_POST['student_username'];
$password = $_POST['student_password'];
$login = new St_Login('student',  $username, $password);//declared in contr.php
$login->amalg_login();
?>