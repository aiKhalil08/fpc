<?php
require '../bin/page_view.php';
require '../bin/contr.php';
check_login('staff_username', './login.php');
show_header('CLASS RESULTS');
handle_session_errors();
$username = $_COOKIE['staff_username'];
$classes = new Get_Class_Students_For_Teacher($username);//declared in contr.php. gets all subjects taught by teacher
$classes = $classes->get();
$period = new Set_Session;//declared in contr.php. gets current session and term
$period = $period->get_cur_sess_term();
$class_res = new Dec_Classes_Results($classes, $period);//declared in page_view.php
if (!isset($_POST['sel_class_sub']) && !isset($_POST['sel_subject_sub']) && !isset($_POST['sel_term_sub'])) {
	$class_res->dec_select_class();
} else if (isset($_POST['sel_class_sub']) && !isset($_POST['sel_subject_sub']) && !isset($_POST['sel_term_sub'])) {
	if (empty($_POST['class'])) {
		$_SESSION['errors'] = 'PLEASE SELECT A CLASS';
		header('location: ./class_results.php');
		die();
	}
	$class = $_POST['class'];
	$orig_class = $class;
	if ($class == 'JSS 1A' || $class == 'JSS 1B') {
		$class = 'JSS 1';
	}
	if ($class == 'JSS 2A' || $class == 'JSS 2B') {
		$class = 'JSS 2';
	}
	if ($class == 'JSS 3A' || $class == 'JSS 3B') {
		$class = 'JSS 3';
	}
	$subjects = new Get_Subjects($class, 1);
	$subjects = $subjects->get_infof();
	$class_res->dec_select_subject($orig_class, $subjects);
} else if (!isset($_POST['sel_class_sub']) && isset($_POST['sel_subject_sub']) && !isset($_POST['sel_term_sub'])) {
	if (empty($_POST['subject'])) {
		$_SESSION['errors'] = 'PLEASE SELECT A SUBJECT';
		header('location: ./class_results.php');
		die();
	}
	$class = $_POST['class'];
	$subject = $_POST['subject'];
	$session = $_POST['session'];
	$class_res->dec_select_term($class, $subject, $session);
}
show_footer();
?>