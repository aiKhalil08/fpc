<?php
require_once '../bin/start_session.php';
require '../bin/page_view.php';
require '../bin/contr.php';
require '../bin/view.php';
require '../bin/sidebar_items.php';
ob_start();
check_login('staff_username', './login.php');
check_request(false, './view_classes.php');

$username = $_COOKIE['staff_username'];
$classes = new Get_Class_Students_For_Teacher($username);//declared in contr.php. gets all subjects taught by teacher
$classes = $classes->get();
$period = new Set_Session;//declared in contr.php. gets current session and term
$period = $period->get_cur_sess_term();
$class_res = new Dec_Classes_Results($classes, $period);//declared in page_view.php
if (!isset($_POST['sel_subject_sub']) && !isset($_POST['sel_term_sub'])) {
	if (empty($_GET['c'])) {
		$_SESSION['errors'] = ['Please select a class.'];
		header('location: ./view_classes.php');
		die();
	}

    // check if class is valid
    $cl = base64_decode($_GET['c']);
    $ar = [];
    if (preg_match('/^JSS (\d)/', $cl, $ar)) {
        if (!in_array($ar[1], range(1,3))) header('location: ./view_classes.php');
    } else if (preg_match('/^SSS (\d)/', $cl, $ar)) {
        if (!in_array($cl, CLASSES)) header('location: ./view_classes.php');
    } else header('location: ./view_classes.php');

	$class = base64_decode($_GET['c']);
	if ($class == 'JSS 1A' || $class == 'JSS 1B') {
		$clas = 'JSS 1';
	}
	if ($class == 'JSS 2A' || $class == 'JSS 2B') {
		$clas = 'JSS 2';
	}
	if ($class == 'JSS 3A' || $class == 'JSS 3B') {
		$clas = 'JSS 3';
	}
	$subjects = new Get_Subjects($clas, 1);
	$subjects = $subjects->get_infof();
} else if (isset($_POST['sel_subject_sub']) && !isset($_POST['sel_term_sub'])) {
	if (empty($_POST['subject'])) {
		$_SESSION['errors'] = ['Please select a subject.'];
		header('location: '.$_SERVER['HTTP_REFERER']);
		die();
	}
	$class = $_POST['class'];
	$subject = $_POST['subject'];
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
	<title><?=$class?> SPREADSHEET</title>
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
            <h3><?=$class?> SPREADSHEET</h3>
			<?=handle_session_errors();?>
		    <?php
            if (!isset($_POST['sel_subject_sub']) && !isset($_POST['sel_term_sub'])) {
				echo $class_res->dec_select_subject($class, $subjects);
			} else if (isset($_POST['sel_subject_sub']) && !isset($_POST['sel_term_sub'])) {
				echo $class_res->dec_select_term($class, $subject, $session);
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