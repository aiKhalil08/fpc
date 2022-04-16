<?php
require_once '../bin/start_session.php';
require_once '../bin/contr.php';
require '../bin/page_view.php';
check_login('admin_username', './login.php');
handle_session_errors();
$req = $_GET['pe'];
if ($req == 'tn') {
	$type = 'student';
} else if ($req == 'fa') {
	$type = 'staff';
}
show_header('ADD '.strtoupper($type).' BIO');
$id = $_GET['id'];
$obj = new Get_Bio($type, $id);//declared in contr.php
$array = $obj->get_biof();
if ($array) {
	$existing = true;
} else {
	$existing = false;
}
$add_obj = new Dec_Editst_Bio($type, $id, $existing, $array);//declared in page_view.php
$add_obj->dec_addst_bio();
?>
<?php show_footer(); ?>