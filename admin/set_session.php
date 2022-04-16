<?php
require_once '../bin/start_session.php';
require_once '../bin/contr.php';
require '../bin/page_view.php';
check_login('admin_username', './login.php');
show_header('SET SESSION');
handle_session_errors();
$current = Set_Session::get_cur_sess_term();
$current_session = $current['session'];
$current_term = $current['term'];
$form = new Dec_Set_Session($current_session, $current_term);//declared in page_view.php
echo $form->dec_form();
show_footer(); ?>