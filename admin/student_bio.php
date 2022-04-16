<?php
require_once '../bin/start_session.php';
require '../bin/page_view.php';
require '../bin/contr.php';
require '../bin/view.php';
check_login('admin_username', './login.php');
$id = @$_GET['id'];
$bio = new Get_St_InfoBio($id, 'student');
$result = $bio->get_infobio();
show_header($result['student_first_name'].' '.$result['student_last_name']);
$view = new Display_Student_Bio($result, 'student');
$view->create_view();
?>
<?php show_footer(); ?>