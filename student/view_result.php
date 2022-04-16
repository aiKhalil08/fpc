<?php
require '../bin/page_view.php';
require '../bin/view.php';
require '../bin/contr.php';
handle_session_errors();
check_login('student_username', './login.php');
$id = $_COOKIE['student_id'];
$info = new View_St('student', $id);//gets info for student. declared in contr.php
$info = $info->retrieve_all();
$fname = $info[0]['student_first_name'];
$lname = $info[0]['student_last_name'];
$name = $fname.' '.$lname;
show_header($name);
$class = $info[0]['student_class'];
$class_teacher = new Get_Classes_Info($class);//gets class teacher for student. declared in contr.php
$class_teacher = $class_teacher->get_infof();
$info[0]['class_teacher'] = $class_teacher;
$student_info = array();
foreach ($info[0] as $key => $value) {
	$student_info[$key] = $value;
}
$info_box = new Show_Info_Box($student_info, 'student');//shows info box for student. declared in view.php
$info_box->show();
$sessions = new Read_Sessions($id);//gets sessions for student. declared in contr.php
$sessions = $sessions->read();
$sessions = array_reverse($sessions);
$passport = $info[0]['student_passport'];
$period = Set_Session::get_cur_sess_term();
$result = new Dec_Select_Result_Period($id, $sessions, $period, $passport);//declares form to select result period. declared in  page_view.php
$result->dec_form();
show_footer();
?>