<?php
require_once '../bin/start_session.php';
require_once '../bin/errorlib.php';
require '../bin/page_view.php';
check_login('admin_username', './login.php');
show_header('DELETE STUDENT');
handle_session_errors();
$form = new Dec_Student_Delete();//declared in page_view.php
echo $form->dec_form();
show_footer(); ?>