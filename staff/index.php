<?php
require '../bin/page_view.php';
require '../bin/start_session.php';
check_login('staff_username', './login.php');
show_header('INDEX');
$sidebar_array = array('VIEW CLASS STUDENTS'=>'./view_student.php', 'STUDENT REGISTRATION.'=>'./student_registration.php', 'TAKE STUDENTS\' ATTENDANCE.'=>'take_attendance.php', 'ADD/EDIT RESULTS.'=>'./add_results.php', 'VIEW SUBJECT SPREADSHEETS.'=>'./subject_results.php', 'VIEW CLASS SPREADSHEETS.'=>'./class_results.php', 'VIEW STUDENT\'S RESULT.'=>'./student_results.php', 'PUBLISH STUDENTS\' RESULTS.'=>'./publish_results.php', 'WRITE CLASSTEACHER\'S COMMENTS'=>'./write_classteacher_comments.php');
if ($_COOKIE['staff_role'] == 'PRINCIPAL') {
	$sidebar_array['WRITE PRINCIPAL\'S COMMENTS'] = './write_principal_comments.php';
}
$sidebar_array['MAILBOX.'] = '../mailbox/index.php?pe='.base64_encode($_COOKIE['user_type']).'&me='.base64_encode($_COOKIE['staff_username']);
?>
<h1>HI, <?= strtoupper($_COOKIE['staff_username']) ?></h1>
<?php
create_sidebar($sidebar_array);
show_footer();
?>