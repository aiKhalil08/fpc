<?php
require '../bin/page_view.php';
require '../bin/view.php';
require '../bin/contr.php';
check_login('staff_username', './login.php');
show_header('STUDENTS REGISTRATION');
handle_session_errors();
if (!$_REQUEST && !$_SESSION) header('location: ./student_registration.php');
$id = $_GET['id'];
$id = base64_decode($id);
$class = $_GET['cl'];
$class = base64_decode($class);
if ($class == 'JSS 1A' || $class == 'JSS 1B') {
	$class = 'JSS 1';
}
if ($class == 'JSS 2A' || $class == 'JSS 2B') {
	$class = 'JSS 2';
}
if ($class == 'JSS 3A' || $class == 'JSS 3B') {
	$class = 'JSS 3';
}
$student_info = new View_St('student', $id);//declared in contr.php . gets st info and passport;
$info = $student_info->retrieve_all();
$student_box = new Display_St($info, 'student');//declared in view.php. displays st info. 
$student_box->display();
$array = new Get_Subjects($class, 1);//gets all subjects offered in selected class. declared in contr.php
$subjects = $array->get_infof();
$period = new Set_Session;//declared in contr.php. gets current session and term
$period = $period->get_cur_sess_term();
$form = new Dec_Registration($id, $class, $period, $subjects);//shows all subjects and which to pick. declared in view.php
$form->dec_form();
?>