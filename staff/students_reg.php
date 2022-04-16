<?php
require '../bin/page_view.php';
require '../bin/view.php';
require '../bin/contr.php';
check_login('staff_username', './login.php');
show_header('STUDENTS REGISTRATION');
if (!$_REQUEST) header('location: ./student_registration.php');
$class = $_POST['class'];
if ($class == '') header('location: ./student_registration.php');
$session = $_POST['session'];
$term = $_POST['term'];
$array = new Get_Info_Class_Role($class, 'students');//gets all students in class. declared in contr.php
$students = $array->get_infof();
if (!$students) {
	echo '<h3>THE SELECTED CLASS IS EMPTY.</h3>';
} else {
	$registered = new Check_Registered($students, $session);//checks registered students. declared in contr.php
	$students = $registered->check();
	$dec_studs = new Dec_Students_Reg($students);//declares students to be registered. declared in view.php
	$dec_studs->dec_form();	
}
?>