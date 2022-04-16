<?php
require '../bin/page_view.php';
require '../bin/view.php';
require '../bin/contr.php';
check_login('student_username', './login.php');
handle_session_errors();
$sidebar_array = array('VIEW STUDENT INFO'=>'./student_bio.php', 'VIEW SUBJECTS'=>'./class_subjects.php', 'VIEW RESULTS'=>'./view_result.php', 'PAY SCHOOL CHARGES'=>'./pay_charges.php', 'MAILBOX.' => '../mailbox/index.php?pe='.base64_encode($_COOKIE['user_type']).'&me='.base64_encode($_COOKIE['student_username']));
$id = $_COOKIE['student_id'];
$info = new View_St('student', $id);//gets info for student. declared in contr.php
$info = $info->retrieve_all();
$fname = $info[0]['student_first_name'];
$lname = $info[0]['student_last_name'];
$name = $fname.' '.$lname;
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
show_header($name);
create_sidebar($sidebar_array);
show_footer();
?>