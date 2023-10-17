<?php
require_once '../bin/contr.php';
require_once '../bin/start_session.php';
require_once '../bin/errorlib.php';
require '../bin/page_view.php';
require '../bin/sidebar_items.php';
ob_start();
check_login('admin_username', './login.php');
check_request(false, './index.php');
$type = @$_POST['type'];
$existing = $_POST['existing'];
if ($type == 'student') {
	$id = $_POST['id'];
	$p_name = $_POST['parent_name'];
	$p_phone = $_POST['parent_phone'];
	$p_email = $_POST['parent_email'];
	$s_dob = $_POST['student_dob'];
	$s_address = $_POST['student_address'];
	$s_storg = $_POST['student_storg'];
	$s_gender = $_POST['student_gender'];
	$s_religion = $_POST['student_religion'];
	$s_passport = $_FILES['student_passport'];
} else if ($type == 'staff') {
	$id = $_POST['id'];
	$s_phone = $_POST['staff_phone'];
	$s_email = $_POST['staff_email'];
	$s_dob = $_POST['staff_dob'];
	$n_name = $_POST['nok_name'];
	$n_phone = $_POST['nok_phone'];
	$s_address = $_POST['staff_address'];
	$s_storg = $_POST['staff_storg'];
	$s_gender = $_POST['staff_gender'];
	$s_religion = $_POST['staff_religion'];
	$s_passport = $_FILES['staff_passport'];
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
	<title>ADD <?=strtoupper($type)?></title>
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
		<section class='forms  add_bio_forms'>
            <h3><?=strtoupper($type)?> BIODATA</h3>
            <?php
			if ($type == 'student') {
				$add_bio = new Editstudent_bio($id, $p_name, $p_phone, $p_email, $s_dob, $s_address, $s_storg, $s_gender, $s_religion, $s_passport, $existing);//declared in contr.php
				$add_bio->edit_bio();
			} else if ($type == 'staff') {
				$add_bio = new Editstaff_bio($id, $s_phone, $s_email, $s_dob, $n_name, $n_phone, $s_address, $s_storg, $s_gender, $s_religion, $s_passport, $existing);//declared in contr.php
				$add_bio->edit_bio();
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