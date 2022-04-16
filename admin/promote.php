<?php
require '../bin/page_view.php';
require '../bin/view.php';
require '../bin/contr.php';
check_login('admin_username', './login.php');
show_header('PROMOTE STUDENTS');
handle_session_errors();
if (!$_REQUEST) {
	$_SERVER['errors'] = 'PLEASE SELECT A CLASS.';
	header('location: ./promote_students.php');
	die();
}
if (isset($_POST['students'])) {
	$type = 'selected';
	$students = $_POST['students'];
}
if (isset($_POST['mark_all'])) {
	$type = 'all';
	$students = $_POST['mark_all'];
}
$cur_class = $_POST['class'];
$period = Set_Session::get_cur_sess_term();
$period = $period['session'];
if (preg_match('/SSS 3/', $cur_class)) {
	$graduate = new Graduate_Students($type, $students, $cur_class, $period);//declared in contr.php ggraduates selected students
	$graduate->amalg_graduate_students();
} else {
	$next_class = $_POST['next_class'];
	$promote = new Promote_Students($type, $students, $cur_class, $next_class, $period);//declared in contr.php promoptes selected students to next class;
	$promote->amalg_promote_students();
	$send_type = 'admin';
	$send_username = 'admin';
	$receipients = array();
	if ($type == 'selected') {
		$index = 0;
		foreach ($students as $student) {
			$info = new View_St('student', $student);//gets info for student. declared in contr.php
			$info = $info->retrieve_all();
			$receipients[$index]['username'] = $info[0]['student_username'];
			$receipients[$index]['name'] = $info[0]['student_first_name'].' '.$info[0]['student_last_name'];
			$index++;
		} 
	} else if ($type == 'all') {
		$info = new Get_Info_Class_Role($next_class, 'students');
		$info = $info->get_infof();
		$index = 0;
		foreach ($info as $key => $value) {
			$receipients[$index]['username'] = $value['student_username'];
			$receipients[$index]['name'] = $value['student_first_name'].' '.$value['student_last_name'];
			$index++;
		}
	}
	$rec_type = 'student_username';
	$title = 'NOTIFICATION OF PROMOTION.';
	foreach ($receipients as $receipient) {
		$mail = 'Congratulations, '.$receipient['name'].'. This is to inform you that you have been promoted to '.$next_class.'.';
		$send_mail = new Send_Mail(base64_encode($send_type), base64_encode($send_username), $rec_type, $receipient['username'], $title, $mail);//declared in contr.php
		$send_mail->amalg_send_mail();
	}
}
show_footer();
?>