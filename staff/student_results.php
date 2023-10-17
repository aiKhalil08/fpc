<?php
require_once '../bin/start_session.php';
require '../bin/page_view.php';
require '../bin/contr.php';
require '../bin/view.php';
require '../bin/sidebar_items.php';
ob_start();
check_login('staff_username', './login.php');

$username = $_COOKIE['staff_username'];
$classes = new Get_Class_Students_For_Teacher($username);//declared in contr.php. gets all subjects taught by teacher
$classes = $classes->get();
$period = new Set_Session;//declared in contr.php. gets current session and term
$period = $period->get_cur_sess_term();
if ($classes) $student_res = new Dec_Students_Results($classes, $period);//declared in page_view.php

if (isset($_POST['sel_class_sub']) && !isset($_POST['sel_student_sub']) && !isset($_POST['sel_session_sub'])) {//chooses student
	if (empty($_POST['class'])) {
		$_SESSION['errors'] = ['Please select a class.'];
		header('location: ./student_results.php');
		die();
	}
	$class = $_POST['class'];
	$array = new Get_Info_Class_Role($class, 'students');//gets all students in class. declared in contr.php
	$students = $array->get_infof();
} else if (isset($_POST['sel_student_sub']) && !isset($_POST['sel_class_sub']) && !isset($_POST['sel_session_sub'])) {//chooses session
	if (empty($_POST['student'])) {
		$_SESSION['errors'] = ['Please select a student.'];
		header('location: ./student_results.php');
		die();
	}
	$class = $_POST['class'];
	$student = explode('_',$_POST['student']);
	$student_id = trim($student[0]);
	$student_name = trim($student[1]);
	$sessions = new Read_Sessions($student_id);//gets sessions for student. declared in contr.php
	$sessions = $sessions->read();
	$sessions = array_reverse($sessions);
} else if (isset($_POST['sel_session_sub']) && !isset($_POST['sel_student_sub']) && !isset($_POST['sel_class_sub'])) {//chooses subject and term
	if (empty($_POST['session'])) {
		$_SESSION['errors'] = ['Please select a session.'];
		header('location: ./student_results.php');
		die();
	}
	$class = $_POST['class'];
	$student_id = $_POST['student_id'];
	$student_name = $_POST['student_name'];
	$session = $_POST['session'];
}

?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<link rel="stylesheet" href="../style/style.css">
    <!-- <script src="https://kit.fontawesome.com/39a92e8fbb.js" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="../style/fontawesome/css/all.css">
	<title>STUDENT RESULTS</title>
</head>
<body>
    <header>
        <div id='header_div' class='fa-xl'>
            <div id='motto'>If education is exspensive, try ignorance.</div>
            <i id='sidebar_control' class="fa-solid fa-bars"></i>
            <a id='home_icon' href='./index.php'><i class="fa-solid fa-house"></i></a>
            <a id='logout_icon' href='./logout.php'><i class="fa-solid fa-right-from-bracket"></i></a>
        </div>
	</header>
    <aside class='sidebar'>
        <div class='header'>
			<a href='./staff_bio.php?id=<?=$_COOKIE['staff_id']?>'>
            <figure>
                <figcaption><?=$_COOKIE['staff_first_name']?> <?=$_COOKIE['staff_last_name']?></figcaption>
                <img src='../bin/st_sidebar_img.php?id=<?=$_COOKIE['staff_id']?>&t=staff' alt='<?=$_COOKIE['staff_first_name']?> <?=$_COOKIE['staff_last_name']?>'>
            </figure>
            </a>
        </div>
        <nav>
            <ul><?= create_sidebar('staff');?></ul>
        </nav>
    </aside>
	<main>
        <?=check_js_enabled();?>
        <section class='student_results'>
            <h3>STUDENT RESULTS</h3>
			<?=handle_session_errors();?>
			<?php
			if (!isset($_POST['sel_class_sub']) && !isset($_POST['sel_student_sub']) && !isset($_POST['sel_session_sub'])) {//chooses class
				echo $classes ? $student_res->dec_select_class() : '<strong>YOU ARE NOT THE CLASS TEACHER OF ANY CLASS.<strong>';
			} else if (isset($_POST['sel_class_sub']) && !isset($_POST['sel_student_sub']) && !isset($_POST['sel_session_sub'])) {//chooses student
				if ($students) {
					echo $student_res->dec_select_student($students, $class);
				} else {
					echo '<strong>THE SELECTED CLASS IS EMPTY.</strong>';
				}
			} else if (isset($_POST['sel_student_sub']) && !isset($_POST['sel_class_sub']) && !isset($_POST['sel_session_sub'])) {//chooses session
				echo $student_res->dec_select_period($student_id, $student_name, $sessions, $class);
			}
			?>
        </section>
    </main>
    <footer>
        <div>
            <span><a href='../school/index.php' target='_blank'>Homepage</a></span>
            <span><a href='../school/index.php' target='_blank'>Follow on Facebook</a></span>
            <span><a href='https://wa.me/+2347062278821/?text=Hello FPC admin, I am directed here from your website. I want to make an enquiry about the school. My name is __' target='_blank'>Chat on Whatsapp</a></span>
        </div>
        <div>
            <span><a href='../school_blog/all_posts.php' target='_blank'>School Blog</a></span>
            <span><a href='../school/about_school.php' target='_blank'>About school</a></span>
            <span id='last_one'></span>
        </div>
        <div id='devs_contact'><a href='../school/developers_contact.php' target='_blank'>Contact Developer</a></div>
        <div id='copyright_info'>&#x00a9; <?=date('Y')?> FOCAL POINT COLLEGE.</div>
    </footer>
</body>
<script src='../js/layout.js'></script>
</html>