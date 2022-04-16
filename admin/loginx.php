<?php
require_once '../bin/start_session.php';
require '../bin/contr.php';
//require '../bin/errorlib.php';
$login = @new AdminLogin($_POST['admin_username'], $_POST['admin_password']);
try {
	$login->admin_login();
} catch (CustomException $e) {
	$_SESSION['login_errors'] = $e->getMessage();
	handle_exception_obj($e, 1, './login.php');
}
?>