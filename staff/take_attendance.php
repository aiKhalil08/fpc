<?php
require_once '../bin/start_session.php';
require '../bin/page_view.php';
require '../bin/contr.php';
require '../bin/view.php';
require '../bin/sidebar_items.php';
ob_start();
check_login('staff_username', './login.php');

if (!isset($_POST['take_attend_sub'])) {
	$username = $_COOKIE['staff_username'];
    $classes = new Get_Class_Students_For_Teacher($username);//declared in contr.php. gets all subjects taught by teacher
    $classes = $classes->get();
    if ($classes) $take_attend = new Dec_Take_Attendance($classes);//declared in page_view.php
} else {
    if ($_POST['class'] == '') {
        $_SESSION['errors'] = ['Please select a class.'];
        header('location: ./take_attendance.php');
        die();
    }
    $class = $_POST['class'];
    $students = new Get_Info_Class_Role($class, 'students');//gets students in selected class. declared in contr.php.
    $students = $students->get_infof();
    if ($students) {
        $mark = new Dec_Mark_Attendance($students, $class);//decs form to mark attendance from. declared in view.php.
    }
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
	<title>TAKE ATTENDANCE</title>
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
        <section class='students_reg_table select_subjects'>
            <h3>TAKE ATTENDANCE</h3>
			<?=handle_session_errors();?>
			<?php 
            if (!isset($_POST['take_attend_sub'])) {
                if ($classes) echo $take_attend->dec_form();
                else echo '<strong>YOU ARE NOT THE CLASS TEACHER OF ANY CLASS.</strong>';
			} else {
                if (!$students) {
                    echo '<strong>THE SELECTED CLASS IS EMPTY.</strong>';
                } else {
                    echo $mark->dec_form();	
                }
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
<script src='../js/mark_all.js'></script>
<script>
	if ('<?=isset($_POST['take_attend_sub'])?>') {
		document.querySelector('form [name=mark_all]').addEventListener('change', function (e){mark_all(e, this);});
		document.querySelectorAll('form [type=checkbox]').forEach(e => e.addEventListener('change', function (e){remove_mark_all(e, this)}));
	}
</script>
</html>