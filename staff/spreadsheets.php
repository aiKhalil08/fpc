<?php
require '../bin/page_view.php';
require '../bin/view.php';
require '../bin/contr.php';
check_login('staff_username', './login.php');
if (!$_REQUEST) header('location: ./login.php');
if (basename($_SERVER['HTTP_REFERER']) == 'subject_results.php') {
	$subject_class = $_POST['subject_class'];
	$subject_class = explode('-', $subject_class);
	$subject = trim($subject_class[0]);
	$class = trim($subject_class[1]);
	$term = $_POST['term'];
	$session = $_POST['session'];
	$result_type = 'all';
	$class_sub = 'subject';	
}
if (basename($_SERVER['HTTP_REFERER']) == 'class_results.php') {
	if (empty($_POST['term'])) {
		$_SESSION['errors'] = 'PLEASE SELECT A TERM.';
		header('location: ./class_results.php');
		die();
	}
	$subject = $_POST['subject'];
	$class = $_POST['class'];
	$session = $_POST['session'];
	$term = $_POST['term'];
	$result_type = 'all';
	$class_sub = 'class';
}
show_header(strtoupper($subject).' '.$class.' SPREADSHEET');
$check = new Check_Class_Result($subject, $class, $session, $term, $result_type, 1, $class_sub);//checks if result for class exists. declared in contr.php
$results = $check->amalg_check_class_result();//returns true if result for selected class exists
$spreadsheet = new Show_Spreadsheet($results, $subject, $class, $session, $term, $result_type);//declared in view.php. declares 	form where result in inputted
$spreadsheet->show();
show_footer();
?>