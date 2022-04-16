<?php
require '../bin/page_view.php';
require '../bin/view.php';
require '../bin/contr.php';
check_login('staff_username', './login.php');
show_header('WRITE COMMENTS');
handle_session_errors();
if (!$_REQUEST) {
	header('location: ./write_classteacher_comments.php');
	die();
}
if ($_POST['class'] == '') {
	$_SESSION['errors'] = 'PLEASE SELECT A CLASS.';
	header('location: ./write_classteacher_comments.php');
	die();
}
$class = $_POST['class'];
$type = $_POST['type'];
$students = new Get_Info_Class_Role($class, 'students', 1);
$students = $students->get_infof();
if (!$students) {
	echo '<h3>THE SELECTED CLASS IS EMPTY.</h3>';
} else {
	$period = Set_Session::get_cur_sess_term();
	$session = $period['session'];
	$term = $period['term'];
	$write_comms = new Dec_Write_Students_Comments($students, $class, $session, $term, $type);//declares form to write comments. declred in view.php
	$write_comms->dec_form();
}
show_footer();
?>