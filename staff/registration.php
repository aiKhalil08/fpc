<?php
require '../bin/page_view.php';
require '../bin/contr.php';
check_login('staff_username', './login.php');
show_header('REGISTRATION');
if (!$_REQUEST) header('location: ./student_registration.php');
$subjects = $_POST['subjects'];
$student_id = $_POST['student_id'];
$student_class = $_POST['student_class'];
$session = $_POST['session'];
$reg = new Register_Student($subjects, $student_id, $student_class, $session);//registers student. declared in contr.php
$reg->amalg_register_student();
show_footer();
?>