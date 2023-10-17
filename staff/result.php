<?php
require_once '../bin/start_session.php';
require '../bin/page_view.php';
require '../bin/contr.php';
require '../bin/view.php';
require '../bin/sidebar_items.php';
ob_start();
check_login('staff_username', './login.php');
check_request(false, './index.php');

$student_id = $_POST['student_id'];
$student_name = $_POST['student_name'];
$class = $_POST['class'];
$session = $_POST['session'];
$term = $_POST['term'];


$student_info = new Get_St_InfoBio($student_id, 'student');//new View_St('student', $id);//declared in contr.php . gets st info and passport;
$info = $student_info->get_infobio();
$gender = $info['student_gender'];
$passport = $info['student_passport'];

$check = new Check_Student_Result($student_id, $session, $term);//checks result for student. declared in contr.php
$results = $check->amalg_check_student_result();//returns true if result for selected class exists

$attendance = @Mark_Attendance::get_attendance($student_id, $session, $term);//gets attendance for student

$comments = Write_Comments::get_comments($student_id, $session, $term);//gets comments for student. declared in contr.php
$result_view = new Show_Student_Result($results, $attendance, $comments, $student_name, $class, $session, $term, $gender, $passport);//declared in view.php. declares 	form where result in inputted

?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<link rel="stylesheet" href="../style/style.css">
	<link rel="stylesheet" href="../style/resultprint.css"> <!-- print.css holds style for print media -->
    <!-- <script src="https://kit.fontawesome.com/39a92e8fbb.js" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="../style/fontawesome/css/all.css">
	<title><?=$student_name?> RESULT</title>
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
        <section class='spreadsheets'>
            <h3><?=$student_name?> RESULT</h3>
			<div id='result_motto'>If education is exspensive, try ignorance.</div>
			<?=handle_session_errors();?>
		    <?php
			echo $result_view->show();
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
<script src='../js/sticky_table_parts.js'></script>
<script>
    window.onload = makeSticky;
</script>
</html>