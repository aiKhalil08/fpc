<?php
require_once '../bin/start_session.php';
require_once '../bin/contr.php';
require '../bin/page_view.php';
check_login('admin_username', './login.php');
show_header('ADD STAFF');
handle_session_errors();
$existing = false;
$array = false;
if (@$_REQUEST['id']) {
	$id = $_GET['id'];
	$existing = true;
	$obj = new Get_Info('staff',$id);//declared in view.php
	$array = $obj->get_infof();
}
$add_obj = new Dec_Addst('staff', $existing, $array);//declared in page_view.php
$add_obj->dec_addst();
?>
<?php show_footer(); ?>