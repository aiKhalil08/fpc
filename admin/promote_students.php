<?php
require '../bin/page_view.php';
require '../bin/contr.php';
check_login('admin_username', './login.php');
show_header('PROMOTE STUDENTS');
handle_session_errors();
$period = Set_Session::get_cur_sess_term();
$period = $period['session'];
$promoted = Promote_Students::get_promoted($period);//gets array of promoted classes
$classes = new Dec_Promote_Classes($promoted);//declares form to choose class to be promoted from. declared in page_view.php
$classes->dec_form();
show_footer();
?>