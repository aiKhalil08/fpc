<?php
require '../bin/contr.php';
require '../bin/view.php';
require_once '../bin/start_session.php';
require '../bin/page_view.php';
$type_req = $_GET['type'];
$met_req = $_GET['method'];
switch ($type_req) {
	case 'nt':
		$type = 'student';
		break;
	case 'fa':
		$type = 'staff';
		break;
}
switch ($met_req) {
	case 'lc':
		$method = 'class_role';
		$input = $_POST['class_role'];
		break;
	case 'or':
		$method = 'class_role';
		$input = $_POST['class_role'];
		break;
	case 'us':
		$method = 'surname';
		$input = $_POST['surname'];
		break;
}
show_header(strtoupper($type).'S SEARCH');
$search = new Search_St($type, $method, $input);//declared in contr.php
$result = $search->search();
$view = new Display_All_St($result, $type);
$view->create_view();
?>