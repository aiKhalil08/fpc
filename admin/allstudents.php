<?php
require_once '../bin/start_session.php';
require '../bin/page_view.php';
require '../bin/contr.php';
require '../bin/view.php';
check_login('admin_username', './login.php');
show_header('ALL STUDENTS');
$result = new View_St('student');//declared in contr.php
$all_students = $result->retrieve_all();
$view = new Display_All_St($all_students, 'student');//declared in view.php
$view->create_view();
?>
<?php show_footer(); ?>