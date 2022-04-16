<?php
require_once '../bin/start_session.php';
require_once '../bin/errorlib.php';
require '../bin/page_view.php';
check_login('admin_username', './login.php');
show_header('STUDENT SEARCH');
handle_session_errors();
$req = $_GET['method'];
switch ($req) {
	case 'lc':
		$method = 'class';
		break;
	case 'us':
		$method = 'surname';
		break;
	default:
		break;
}
$form = new Dec_Student_Search($method);//declared in page_view.php
echo $form->dec_form();
show_footer(); ?>
