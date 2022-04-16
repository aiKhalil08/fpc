<?php
require '../bin/page_view.php';
require '../bin/view.php';
require '../bin/contr.php';
check_login('staff_username', './login.php');
if (!$_REQUEST) {
	header('location: ./student_results.php');
	die();
}
$student_id = $_POST['student_id'];
$student_name = $_POST['student_name'];
$class = $_POST['class'];
$session = $_POST['session'];
$term = $_POST['term'];
$info = new View_St('student', $student_id);
$info = $info->retrieve_all();
$passport = $info[0]['student_passport'];
show_header($student_name.'\'S RESULT');
$check = new Check_Student_Result($student_id, $session, $term);//checks result for student. declared in contr.php
$results = $check->amalg_check_student_result();//returns true if result for selected class exists
$attendance = Mark_Attendance::get_attendance($student_id, $class, $session, $term);//gets attendance for student
$comments = Write_Comments::get_comments($student_id, $session, $term);//gets comments for student. declared in contr.php
$result_view = new Show_Student_Result($results, $attendance, $comments, $student_name, $class, $session, $term, $passport);//declared in view.php. declares 	form where result in inputted
$result_view->show();
show_footer();
?>