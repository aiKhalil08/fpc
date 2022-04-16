<?php
require '../bin/page_view.php';
require '../bin/view.php';
require '../bin/contr.php';
check_login('student_username', './login.php');
$name = $_COOKIE['student_first_name'].' '.$_COOKIE['student_last_name'];
show_header($name);
$class = $_COOKIE['student_class'];
$id = $_COOKIE['student_id'];
$all_subjects = new Get_Subjects($class, 1);
$all_subjects = $all_subjects->get_infof();
$period = Set_Session::get_cur_sess_term();
$session = $period['session'];
$student_subjects = new Get_Session_Subjects_For_Student($id, $session);
$student_subjects = $student_subjects->get_infof();
$view = new Show_Student_Subjects($all_subjects, $student_subjects);
$view->show();
show_footer();
?>