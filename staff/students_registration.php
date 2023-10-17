<?php
require_once '../bin/start_session.php';
require '../bin/page_view.php';
require '../bin/contr.php';
require '../bin/view.php';
require '../bin/sidebar_items.php';
ob_start();
check_login('staff_username', './login.php');
check_request(['c'], './view_classes.php');

// check if class is valid
$cl = base64_decode($_GET['c']);
$ar = [];
if (preg_match('/^JSS (\d)/', $cl, $ar)) {
    if (!in_array($ar[1], range(1,3))) header('location: ./view_classes.php');
} else if (preg_match('/^SSS (\d)/', $cl, $ar)) {
    if (!in_array($cl, CLASSES)) header('location: ./view_classes.php');
} else header('location: ./view_classes.php');

$class = base64_decode($_GET['c']);

$period = Set_Session::get_cur_sess_term();
$session = $period['session'];
$term = $period['term'];
$array = new Get_Info_Class_Role($class, 'students');//gets all students in class. declared in contr.php
$students = $array->get_infof();
if ($students) {
	$registered = new Check_Registered($students, $session);//checks registered students. declared in contr.php
	$students = $registered->check();
	$dec_studs = new Dec_Students_Reg($students);//declares students to be registered. declared in view.php
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
	<title><?=$class?> REGISTRATION</title>
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
        <section class='students_reg_table'>
            <h3>ALL STUDENTS</h3>
			<?=handle_session_errors();?>
            <?php
			if (!$students) {
				echo '<strong>THE SELECTED CLASS IS EMPTY.</strong>';
			} else {
                echo '<p><em>Present session: '.$session.'</em></p>';
                echo '<p><em>Present term: '.$term.'</em></p>';
				echo $dec_studs->dec_form();	
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