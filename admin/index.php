<?php
require_once '../bin/start_session.php';
require_once '../bin/errorlib.php';
require '../bin/page_view.php';
check_login('admin_username', './login.php');
show_header('INDEX');
?>
<h1>HI, <?= strtoupper($_COOKIE['admin_username']) ?></h1>
<?php
$sidebar_array  = array('ADD STUDENT' => './addstudent.php', 'ADD STAFF' => './addstaff.php', 'VIEW ALL STUDENTS' => './allstudents.php', 'VIEW ALL STAFFS' => './allstaffs.php', 'VIEW ALL STAFFS' => './allstaffs.php', 'SEARCH STUDENT BY CLASS' => './search_student.php?method=lc', 'SEARCH STUDENT BY SURNAME' => './search_student.php?method=us', 'SEARCH STAFF BY ROLE' => './search_staff.php?method=or', 'SEARCH STAFF BY SURNAME' => './search_staff.php?method=us', 'DELETE STUDENT(USERNAME)' => './delete_student.php', 'DELETE STAFF(USERNAME)' => './delete_staff.php', 'PROMOTE STUDENTS'=>'./promote_students.php', 'SET SESSION AND TERM.' => './set_session.php', 'SET ALL SUBJECTS.' => './set_all_subjects.php', 'SET SUBJECTS FOR EACH CLASS.' => './set_class_subjects.php', 'SET CLASS TEACHER.' => './set_class_teacher.php', 'SET SUBJECT TEACHER.' => './set_subject_teacher.php', 'MAILBOX.' => '../mailbox/index.php?pe='.base64_encode('admin').'&me='.base64_encode('admin'));
create_sidebar($sidebar_array);
show_footer();
?>
