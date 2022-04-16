<?php
require '../bin/page_view.php';
require '../bin/contr.php';
check_login('staff_username', './login.php');
show_header('VIEW STUDENT');
handle_session_errors();
$username = $_COOKIE['staff_username'];
if (!isset($_POST['sel_class_sub'])) {
	$classes = new Get_Class_Students_For_Teacher($username);//declared in contr.php. gets all subjects taught by teacher
	$classes = $classes->get();
	$select_student = new Dec_Select_View_Student($classes);//declared in page_view.php
	$select_student->dec_select_class();
} else {
	if ($_POST['class'] == '') {
		$_SESSION['errors'] = 'PLEASE SELECT A CLASS.';
		header('location: ./view_student.php');
		die();
	}
	$class = $_POST['class'];
	$students = new Get_Info_Class_Role($class, 'students');
	$students = $students->get_infof();
	Dec_Select_View_Student::dec_select_student($students);
}
show_footer();
?>