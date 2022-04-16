<?php
require_once '../bin/start_session.php';
require_once '../bin/contr.php';
require '../bin/page_view.php';
check_login('admin_username', './login.php');
show_header('ADD STUDENT BIO');
handle_session_errors();
$existing = false;
$array = false;
$req = $_GET['te'];
if ($req == 'tn') {
	$type = 'student';
} else if ($req == 'fa') {
	$type = 'staff';
}
if (@$_REQUEST['id']) {
	$id = $_GET['id'];
	$existing = true;
	$obj = new Get_Student_Bio($id);
	$array = $obj->get_bio();
}
$add_obj = new Dec_Editst_Bio($type, $existing, $array);
$add_obj->dec_addst_bio();
?>
<?php show_footer(); ?>