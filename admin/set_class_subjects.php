<?php
require_once '../bin/start_session.php';
require_once '../bin/contr.php';
require '../bin/page_view.php';
check_login('admin_username', './login.php');
show_header('SET CLASS SUBJECTS');
handle_session_errors();
if (!isset($_POST['show_subjects'])) {
	$form = new Dec_Set_Class_Subjects();//shows form to choose class from. declared in page_view.php
	echo $form->dec_classes();
} else {
	$class = $_POST['class'];
	$all_subjects = new Get_Subjects($class);//gets all subject available(not offered) for class. declared in contr.php
	$all_subjects = $all_subjects->get_infof();
	$form = new Dec_Set_Class_Subjects($all_subjects);//declared in page_view.php
	echo $form->dec_form($class);
}
show_footer(); ?>