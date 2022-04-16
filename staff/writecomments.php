<?php
require '../bin/page_view.php';
require '../bin/view.php';
require '../bin/contr.php';
check_login('staff_username', './login.php');
show_header('WRITE COMMENTS');
handle_session_errors();
if (!$_REQUEST) {
	header('location: ./write_classteacher_comments.php');
	die();
}
$type = $_POST['type'];
$students_ids = $_POST['student_ids'];
$comments = $_POST['comments'];
$session = $_POST['session'];
$term = $_POST['term'];
$write_comms = new Write_Comments($students_ids, $comments, $session, $term, $type);//writes students comments. declared in contr.php
$write_comms->amalg_write_comments();
show_footer();
?>