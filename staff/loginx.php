<?php
require '../bin/page_view.php';
require '../bin/contr.php';
check_request(false, './login.php');
if (!$_REQUEST) header('location: ./login.php');
$username = $_POST['staff_username'];
$password = $_POST['staff_password'];
$login = new St_Login('staff',  $username, $password);//declared in contr.php
$login->amalg_login();
?>