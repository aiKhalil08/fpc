<?php
require_once '../bin/start_session.php';
require_once '../bin/contr.php';
require '../bin/page_view.php';
check_login('admin_username', './login.php');
show_header('ADD STUDENT');
handle_session_errors();
$existing = false;
$array = false;
if (@$_REQUEST['id']) {
	$id = $_GET['id'];
	$existing = true;
	$obj = new Get_Info('student', $id);
	$array = $obj->get_infof();
}
$add_obj = new Dec_Addst('student', $existing, $array);
$add_obj->dec_addst();
?>
<?php show_footer(); ?>