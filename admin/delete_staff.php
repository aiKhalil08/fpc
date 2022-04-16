<?php
require_once '../bin/start_session.php';
require_once '../bin/contr.php';
require '../bin/page_view.php';
check_login('admin_username', './login.php');
show_header('DELETE STAFF');
handle_session_errors();
$form = new Dec_Staff_Delete();//declared in page_view.php
echo $form->dec_form();
show_footer(); ?>