<?php
require_once '../bin/start_session.php';
require_once '../bin/contr.php';
require '../bin/page_view.php';
if (!$_REQUEST) header('../index.php');
$type = $_GET['pe'];
$username = $_GET['me'];
show_header('SEND MAIL');
handle_session_errors();
$form = new Dec_Send_Mail($type, $username);//declared in page_view.php
if (!isset($_POST['send_mail_su'])) {
	$form->dec_type();
} else {
	$type = $_POST['type'];
	$array = false;
	if ($type == 'subject_students') {
		$array = new Get_Subject_Classes_For_Teacher(base64_decode($username));
		$array = $array->get();
	}
	if ($type == 'class_students') {
		$array = new Get_Class_Students_For_Teacher(base64_decode($username));
		$array = $array->get();
	}
	if ($type == 'subject_teachers') {
		$info = new Get_Info('student', base64_decode($username), 1);
		$info = $info->get_infof();
		$class = $info['student_class'];
		if (preg_match('/JSS/', $class)) {
			$class = substr($class, 0, 5);
		}
		$array = new Get_Subjects_Teachers(base64_decode($username), $class);
		$array = $array->get_infof();
	}
	if ($type == 'class_teacher') {
		$info = new Get_Info('student', base64_decode($username), 1);
		$info = $info->get_infof();
		$class = $info['student_class'];
		$array = new Get_Class_Teacher($class);
		$array = $array->get_infof();
	}
	echo $form->dec_form($type, $array);
}
show_footer(); ?>