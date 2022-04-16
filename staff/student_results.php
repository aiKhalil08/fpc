<?php
require '../bin/page_view.php';
require '../bin/contr.php';
check_login('staff_username', './login.php');
show_header('STUDENT RESULTS');
handle_session_errors();
$username = $_COOKIE['staff_username'];
$classes = new Get_Class_Students_For_Teacher($username);//declared in contr.php. gets all subjects taught by teacher
$classes = $classes->get();
$period = new Set_Session;//declared in contr.php. gets current session and term
$period = $period->get_cur_sess_term();
$student_res = new Dec_Students_Results($classes, $period);//declared in page_view.php
if (!isset($_POST['sel_class_sub']) && !isset($_POST['sel_student_sub']) && !isset($_POST['sel_session_sub'])) {//chooses class
	$student_res->dec_select_class();
} else if (isset($_POST['sel_class_sub']) && !isset($_POST['sel_student_sub']) && !isset($_POST['sel_session_sub'])) {//chooses student
	if (empty($_POST['class'])) {
		$_SESSION['errors'] = 'PLEASE SELECT A CLASS.';
		header('location: ./student_results.php');
		die();
	}
	$class = $_POST['class'];
	$array = new Get_Info_Class_Role($class, 'students');//gets all students in class. declared in contr.php
	$students = $array->get_infof();
	$student_res->dec_select_student($students, $class);
} else if (isset($_POST['sel_student_sub']) && !isset($_POST['sel_class_sub']) && !isset($_POST['sel_session_sub'])) {//chooses session
	if (empty($_POST['student'])) {
		$_SESSION['errors'] = 'PLEASE SELECT A STUDENT.';
		header('location: ./student_results.php');
		die();
	}
	$class = $_POST['class'];
	$student = explode('_',$_POST['student']);
	$student_id = trim($student[0]);
	$student_name = trim($student[1]);
	$sessions = new Read_Sessions($student_id);//gets sessions for student. declared in contr.php
	$sessions = $sessions->read();
	$sessions = array_reverse($sessions);
	$student_res->dec_select_session($student_id, $student_name, $sessions, $class);
} else if (isset($_POST['sel_session_sub']) && !isset($_POST['sel_student_sub']) && !isset($_POST['sel_class_sub'])) {//chooses subject and term
	if (empty($_POST['session'])) {
		$_SESSION['errors'] = 'PLEASE SELECT A SESSION.';
		header('location: ./student_results.php');
		die();
	}
	$class = $_POST['class'];
	$student_id = $_POST['student_id'];
	$student_name = $_POST['student_name'];
	$session = $_POST['session'];
	$student_res->dec_select_sub_term($student_id, $student_name, $session, $class);
}
show_footer();
?>