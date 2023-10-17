<?php
require_once '../bin/start_session.php';
require '../bin/page_view.php';
require '../bin/contr.php';
require '../bin/view.php';
require '../bin/sidebar_items.php';
ob_start();
check_login('staff_username', './login.php');

if (!isset($_POST['reg_sub'])) {
	check_request(['id', 'cl'], './view_classes.php');
	$id = $_GET['id'];
	$id = base64_decode($id);
	$class = $_GET['cl'];

	// check if class is valid
	$cl = base64_decode($class);
	$ar = [];
	if (preg_match('/^JSS (\d)/', $cl, $ar)) {
		if (!in_array($ar[1], range(1,3))) header('location: ./view_classes.php');
	} else if (preg_match('/^SSS (\d)/', $cl, $ar)) {
		if (!in_array($cl, CLASSES)) header('location: ./view_classes.php');
	} else header('location: ./view_classes.php');

	// checks if id is valid
	if (Database::check_unique_id($id, 'students')) header('location: ./view_classes.php');

	$class = base64_decode($class);
	if ($class == 'JSS 1A' || $class == 'JSS 1B') {
		$class = 'JSS 1';
	}
	if ($class == 'JSS 2A' || $class == 'JSS 2B') {
		$class = 'JSS 2';
	}
	if ($class == 'JSS 3A' || $class == 'JSS 3B') {
		$class = 'JSS 3';
	}
	$student_info = new Get_St_InfoBio($id, 'student');//new View_St('student', $id);//declared in contr.php . gets st info and passport;
	$info = $student_info->get_infobio();
	
	// $student_box = new Display_St($info, 'student');//declared in view.php. displays st info. 
	
	$array = new Get_Subjects($class, 1);//gets all subjects offered in selected class. declared in contr.php
	$subjects = $array->get_infof();
	
	$period = new Set_Session;//declared in contr.php. gets current session and term
	$period = $period->get_cur_sess_term();
	
	$form = new Dec_Registration($id, $class, $period, $subjects);//shows all subjects and which to pick. declared in view.php
} else {
	if (!$_REQUEST) header('location: ./student_registration.php');
	$student_class = $_POST['student_class'];
	if (isset($_POST['mark_all'])) {
		$array = new Get_Subjects($student_class, 1);//gets all subjects offered in selected class. declared in contr.php
		$array = $array->get_infof();
		$subjects = [];
		foreach ($array as $subject) {
			$subjects[] = $subject['subject'];
		}
	} else {
		$subjects = $_POST['subjects'];
	}
	$student_id = $_POST['student_id'];
	$student_class = $_POST['student_class'];
	$session = $_POST['session'];
	$reg = new Register_Student($subjects, $student_id, $student_class, $session);//registers student. declared in contr.php
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
	<title><?= !isset($_POST['reg_sub']) ? $class : $student_class;?> REGISTRATION</title>
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
			<?php if (!isset($_POST['reg_sub'])) {?>
				<h3><?=$info['student_first_name'].' '.$info['student_last_name']?></h3>
				<?=handle_session_errors();?>
				<section class='basic_info field_set'>
					<span class='legend'>Basic info </span>
					<article id='passport'>
						<img src='<?=$info['student_passport']?>' alt='<?=strtoupper($info['student_first_name'])?>'>
					</article>
					<article class='names'>
						<div><span>Student's first name: </span><span><?=strtoupper($info['student_first_name'])?></span></div>
						<div><span>Student's last name: </span><span><?=strtoupper($info['student_last_name'])?></span></div>
						<div><span>Student's username: </span><span><?=strtoupper($info['student_username'])?></span></div>
						<div><span>Student's class: </span><span><?=strtoupper($info['student_class'])?></span></div>
						<div><span>Student's gender: </span><span><?=strtoupper($info['student_gender'])?></span></div>
					</article>
				</section>
				<p>Registered subjects cannnot be changed after registration is complete. Choose carefully!</p>
				<?php
				echo $form->dec_form();
			} else {
				$reg->amalg_register_student();
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
	if ('<?=!isset($_POST['reg_sub'])?>') {
		document.querySelector('form [name=mark_all]').addEventListener('change', function (e){mark_all(e, this);});
		document.querySelectorAll('form [type=checkbox]').forEach(e => e.addEventListener('change', function (e){remove_mark_all(e, this)}));
	}
</script>
</html>