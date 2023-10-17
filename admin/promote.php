<?php
require_once '../bin/start_session.php';
require '../bin/page_view.php';
require '../bin/contr.php';
require '../bin/view.php';
require '../bin/sidebar_items.php';
ob_start();
check_login('admin_username', './login.php');
check_request(false, './promote_students.php');

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
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<link rel="stylesheet" href="../style/style.css">
    <script src='../js/password_prompt.js'></script>
	<!-- <script src="https://kit.fontawesome.com/39a92e8fbb.js" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="../style/fontawesome/css/all.css">
	<title>PROMOTE STUDENTS</title>
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
            <figure>
                <figcaption>ADMINISTRATOR</figcaption>
                <i class="fa-solid fa-user fa-8x"></i>
            </figure>
        </div>
        <nav>
            <ul><?= create_sidebar('admin');?></ul>
        </nav>
    </aside>
	<main>
        <?=check_js_enabled();?>
        <section class='forms promote_forms'>
            <h3>PROMOTE STUDENTS</h3>
            <?=handle_session_errors();?>
            <article class='output choose_tables'>
                <?php
                if (preg_match('/SSS 3/', $cur_class)) {
					$graduate = new Graduate_Students($type, $students, $cur_class, $period);//declared in contr.php graduates selected students
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
						$send_mail = new Send_Mail($send_type, $send_username, $rec_type, $receipient['username'], $title, $mail);//declared in contr.php
						$send_mail->amalg_send_mail();
					}
				}
                ?>
            </article>
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