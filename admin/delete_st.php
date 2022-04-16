<?php
require '../bin/contr.php';
require '../bin/view.php';
require_once '../bin/start_session.php';
require '../bin/page_view.php';
$type_req = $_GET['type'];
$input = $_POST['input'];
switch ($type_req) {
	case 'nt':
		$type = 'student';
		break;
	case 'fa':
		$type = 'staff';
		break;
}
show_header(strtoupper($type).'S DELETE');
$delete = new Delete_St($type, $input);//declared in contr.php
if (!isset($_POST['delete'])) {
	$result = $delete->show_info();
	$proceed = new Proceed_Delete($type, $input, $result);//notifies about sts to be deleted. declared in view.php
	$proceed->proceed();
} else if (isset($_POST['delete'])) {
	$delete->delete();
}
?>