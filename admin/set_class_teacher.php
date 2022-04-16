<?php
require_once '../bin/start_session.php';
require_once '../bin/contr.php';
require '../bin/page_view.php';
check_login('admin_username', './login.php');
show_header('SET CLASS TEACHER');
handle_session_errors();
$all_teachers = new Get_Info_Class_Role('teacher', 'staffs');//Gets all teachers from database. declared in contr.php
$classes_info = new Get_Classes_Info();//Gets classes info from database. declared in contr.php
$all_teachers = $all_teachers->get_infof();
$classes_info = $classes_info->get_infof();
$form = new Dec_Set_Class_Teacher($all_teachers, $classes_info);//declared in page_view.php
echo $form->dec_form();
show_footer(); ?>