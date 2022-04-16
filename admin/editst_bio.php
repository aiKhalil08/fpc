<?php
require '../bin/contr.php';
require_once '../bin/start_session.php';
$type = @$_POST['type'];
$existing = $_POST['existing'];
if ($type == 'student') {
	$id = $_POST['id'];
	$p_name = $_POST['parent_name'];
	$p_phone = $_POST['parent_phone'];
	$p_email = $_POST['parent_email'];
	$s_dob = $_POST['student_dob'];
	$s_address = $_POST['student_address'];
	$s_storg = $_POST['student_storg'];
	$s_gender = $_POST['student_gender'];
	$s_religion = $_POST['student_religion'];
	$s_passport = $_FILES['student_passport'];
} else if ($type == 'staff') {
	$id = $_POST['id'];
	$s_phone = $_POST['staff_phone'];
	$s_email = $_POST['staff_email'];
	$s_dob = $_POST['staff_dob'];
	$n_name = $_POST['nok_name'];
	$n_phone = $_POST['nok_phone'];
	$s_address = $_POST['staff_address'];
	$s_storg = $_POST['staff_storg'];
	$s_gender = $_POST['staff_gender'];
	$s_religion = $_POST['staff_religion'];
	$s_passport = $_FILES['staff_passport'];
}
if ($type == 'student') {
	$add_bio = new Editstudent_bio($id, $p_name, $p_phone, $p_email, $s_dob, $s_address, $s_storg, $s_gender, $s_religion, $s_passport, $existing);//declared in contr.php
	$add_bio->edit_bio();
} else if ($type == 'staff') {
	$add_bio = new Editstaff_bio($id, $s_phone, $s_email, $s_dob, $n_name, $n_phone, $s_address, $s_storg, $s_gender, $s_religion, $s_passport, $existing);//declared in contr.php
	$add_bio->edit_bio();
}
?>