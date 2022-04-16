<?php
require '../bin/page_view.php';
require '../bin/view.php';
require '../bin/contr.php';
check_login('student_username', './login.php');
if (!$_REQUEST) {
	header('location: ./view_result.php');
	die();
}
if ($_POST['session'] == '') {
	$_SESSION['errors'] = 'PLEASE SELECT A SESSION.';
	header('location: ./view_result.php');
	die();
}
if ($_POST['term'] == '') {
	$_SESSION['errors'] = 'PLEASE SELECT A TERM.';
	header('location: ./view_result.php');
	die();
}
$student_id = $_POST['student_id'];
$student_name = $_COOKIE['student_first_name'].' '.$_COOKIE['student_last_name'];
$class = $_COOKIE['student_class'];
$session = $_POST['session'];
$term = $_POST['term'];
$passport = $_POST['student_passport'];
show_header($student_name.'\'S RESULT');
$published = true;
$unpublished_results = new Get_Unpublished_Results($class, $session, $term);//gets unpublished results for class
$unpublisheds = $unpublished_results->amalg_get_unpublished_results();
foreach ($unpublisheds as $unpublished) {
	foreach ($unpublished as $key => $value) {
		switch ($key) {
			case 0:
				$term_word = 'FIRST TERM';
				break;
			case 1:
				$term_word = 'SECOND TERM';
				break;
			case 2:
				$term_word = 'THIRD TERM';
				break;
			default:
				// code...
				break;
		}
		if ($term == $term_word) {
			$published = false;
			break;
		}
	}
}
if ($published) {
	$check = new Check_Student_Result($student_id, $session, $term);//checks result for student. declared in contr.php
	$results = $check->amalg_check_student_result();//returns true if result for selected class exists
	$attendance = Mark_Attendance::get_attendance($student_id, $class, $session, $term);//gets attendance for student. declared in contr.php
	$comments = Write_Comments::get_comments($student_id, $session, $term);//gets comments for student. declared in contr.php
} else {
	$results = false;
	$attendance = false;
	$comments = false;
}
$result_view = new Show_Student_Result($results, $attendance, $comments, $student_name, $class, $session, $term, $passport);//declared in view.php. declares 	form where result in inputted
$result_view->show();
show_footer();
?>