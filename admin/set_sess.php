<?php
require '../bin/contr.php';
require '../bin/view.php';
require_once '../bin/start_session.php';
require '../bin/page_view.php';
check_login('admin_username', './login.php');
show_header('SET SESSION');
handle_session_errors();
if (!$_REQUEST) header('location: ./set_session.php');
$input_session = $_POST['session'];
$input_term = $_POST['term'];
$set_session = new Set_Session($input_session, $input_term);//declared in contr.php
$current = $set_session->get_cur_sess_term();
$current_session = $current['session'];
$current_term = $current['term'];
$view = new Proceed_Change_Term($input_session, $input_term, $current_session, $current_term);//declared in view.php
if (!isset($_POST['set_sess'])) {
	echo $view->dec_proceed();
} else {
	$password = $_POST['set_sess_password'];
	$set_session->change_sess_term($password);
}
?>