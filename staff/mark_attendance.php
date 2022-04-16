<?php
require '../bin/page_view.php';
require '../bin/view.php';
require '../bin/contr.php';
check_login('staff_username', './login.php');
show_header('PUBLISH RESULTS');
handle_session_errors();
if (!$_REQUEST) {
	header('location: ./take_attendance.php');
	die();
}
if ($_POST['class'] == '') {
	$_SESSION['errors'] = 'PLEASE SELECT A CLASS.';
	header('location: ./take_attendance.php');
	die();
}
$class = $_POST['class'];
show_header($class.' ATTENDANCE');
$students = new Get_Info_Class_Role($class, 'students');//gets students in selected class. declared in contr.php.
$students = $students->get_infof();
if (!$students) {
	echo '<h3>THE SELECTED CLASS IS EMPTY.</h3>';
} else {
	$mark = new Dec_Mark_Attendance($students, $class);//decs form to mark attendance from. declared in view.php.
	$mark->dec_form();	
}
show_footer();
?>