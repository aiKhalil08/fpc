<?php
require '../bin/contr.php';
require_once '../bin/start_session.php';
//echo $_POST['student_first_name'];
$type = @$_POST['type'];
if ($type == 'student') {
	$fname = @$_POST['student_first_name'];
	$lname = @$_POST['student_last_name'];
	$class_role = @$_POST['student_class'];
	$uname = @$_POST['student_username'];
} else if ($type == 'staff') {
	$fname = $_POST['staff_first_name'];
	$lname = $_POST['staff_last_name'];
	$class_role = $_POST['staff_role'];
	$uname = $_POST['staff_username'];
}
$existing = false;
$id = false;
if ($_POST['existing']) {
	$existing = true;
}
if ($_POST['id']) {
	$id = $_POST['id'];
}
$add = new AddSt($type, $fname, $lname, $uname, $class_role, $existing, $id);//declared in contr.php
$add->add_st();
?>