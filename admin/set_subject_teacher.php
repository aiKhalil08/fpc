<?php
require_once '../bin/start_session.php';
require_once '../bin/contr.php';
require '../bin/page_view.php';
check_login('admin_username', './login.php');
show_header('SET SUBJECT TEACHER');
handle_session_errors();
$all_teachers = Database::check_unique_class_role('teacher', 'staffs', 1);//declared in contr.php
if (!isset($_POST['show_subjects'])) {
	$form = new Dec_Set_Subject_Teacher();//shows form to choose class from. declared in page_view.php
	echo $form->dec_classes();
} else {
	$class = $_POST['class'];
	$all_subjects = new Get_Subjects($class, 1);//gets all subject offered by the chosen class. declared in contr.php
	$all_subjects = $all_subjects->get_infof();
	$all_teachers = new Get_Info_Class_Role('teacher', 'staffs');//Gets all teachers from database. declared in contr.php
	$all_teachers = $all_teachers->get_infof();
	$form = new Dec_Set_Subject_Teacher($class, $all_subjects, $all_teachers);//declared in page_view.php
	echo $form->dec_form($class);
}
show_footer(); ?>