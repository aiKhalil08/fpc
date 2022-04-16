<?php
require '../bin/page_view.php';
require '../bin/view.php';
require '../bin/contr.php';
check_login('admin_username', './login.php');
show_header('PROMOTE STUDENTS');
handle_session_errors();
if (!$_REQUEST) {
	$_SERVER['errors'] = 'PLEASE SELECT A CLASS.';
	header('location: ./promote_students.php');
	die();
}
$class = $_POST['class'];
$students = new Get_Info_Class_Role($class, 'students');//gets all students in selected class
$students = $students->get_infof();
if (!$students) {
	echo '<h3>THE SELECTED CLASS IS EMPTY.</h3>';
} else {
	$promote = new Dec_Choose_Promote($students, $class);//declares form to who to be promoted. declared in view.php
	$promote->dec_form();
}
show_footer();
?>