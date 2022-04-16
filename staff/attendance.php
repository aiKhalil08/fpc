<?php
require '../bin/page_view.php';
require '../bin/view.php';
require '../bin/contr.php';
check_login('staff_username', './login.php');
show_header('ATTENDANCE');
handle_session_errors();
if (!$_REQUEST) {
	header('location: ./take_attendance.php');
	die();
}
if (isset($_POST['presents'])) {
	$presents = $_POST['presents'];
} else if (isset($_POST['check_all'])) {
	$presents = $_POST['check_all'];
	$presents = explode('&', $presents);
	$presents = array_slice($presents, 0, (sizeof($presents) - 1));
}
$class = $_POST['class'];
$period = Set_Session::get_cur_sess_term();
$mark = new Mark_Attendance($presents, $class, $period);//declared in contr.php. marks attendance for selected class
$mark->amalg_mark_attendance();
show_footer();
?>