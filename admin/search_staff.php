<?php
require_once '../bin/start_session.php';
require_once '../bin/contr.php';
require '../bin/page_view.php';
check_login('admin_username', './login.php');
show_header('STAFF SEARCH');
handle_session_errors();
$req = $_GET['method'];
switch ($req) {
	case 'or':
		$method = 'role';
		break;
	case 'us':
		$method = 'surname';
		break;
	default:
		break;
}
$form = new Dec_Staff_Search($method);//declared in page_view.php
echo $form->dec_form();
show_footer(); ?>