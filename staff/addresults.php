<?php
require '../bin/page_view.php';
require '../bin/view.php';
require '../bin/contr.php';
check_login('staff_username', './login.php');
if (!$_REQUEST) {
	header('location: ./add_results.php');
	die();
}
if (empty($_POST['subject_class']) || empty($_POST['result_type'])) {
	$_SESSION['errors'] = 'PLEASE SELECT CLASS AND RESULT TYPE.';
	header('location: ./add_results.php');
	die();
}
show_header('ADD RESULTS');
$subject_class = $_POST['subject_class'];
$subject_class = explode('-', $subject_class);
$subject = trim($subject_class[0]);
$class = trim($subject_class[1]);
$result_type = $_POST['result_type'];
$session = $_POST['session'];
$term = $_POST['term'];
$check = new Check_Class_Result($subject, $class, $session, $term, $result_type, 1, 'subject');//checks if result for class exists. declared in contr.php
$students = $check->amalg_check_class_result();//returns true if result for selected class exists
$add_res_from = new Dec_Input_Results($students, $subject, $class, $session, $term, $result_type);//declared in view.php. declares 	form where result in inputted
$add_res_from->dec_form();
show_footer();
?>