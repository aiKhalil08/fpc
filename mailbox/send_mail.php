<?php
require_once '../bin/contr.php';
require_once '../bin/start_session.php';
require_once '../bin/errorlib.php';
require '../bin/page_view.php';
require '../bin/sidebar_items.php';
ob_start();
check_request(['pe', 'me'], '../index.php');
$type = $_GET['pe'];
$username = $_GET['me'];
$user_type = new Get_User($type, $username);//declared in contr.php
$type = $user_type->get_userf()['type'];
$username = $user_type->get_userf()['username'];
if ($type != 'admin' && Database::check_unique_username($username, $type.'s')) {
    header('location: ../index.php');
    die;
}
$form = new Dec_Send_Mail($type, $username);//declared in page_view.php
if (isset($_POST['send_mail_su'])) {
	$rec_type = $_POST['type'];
	$array = null;
	if ($rec_type == 'subject_students') {
		$array = new Get_Subject_Classes_For_Teacher($username);
		$array = $array->get();
	}
	if ($rec_type == 'class_students') {
		$array = new Get_Class_Students_For_Teacher($username);
		$array = $array->get();
	}
	if ($rec_type == 'subject_teachers') {
		$info = new Get_Info('student', $username, 1);
		$info = $info->get_infof();
		$class = $info['student_class'];
		if (preg_match('/JSS/', $class)) {
			$class = substr($class, 0, 5);
		}
		$array = new Get_Subjects_Teachers($username, $class);
		$array = $array->get_infof();
	}
	if ($rec_type == 'class_teacher') {
		$info = new Get_Info('student', $username, 1);
		$info = $info->get_infof();
		$class = $info['student_class'];
		$array = new Get_Class_Teacher($class);
		$array = $array->get_infof();
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
	<title>SEND MAIL</title>
</head>
<body>
    <header>
        <div id='header_div' class='fa-xl'>
            <div id='motto'>If education is exspensive, try ignorance.</div>
            <i id='sidebar_control' class="fa-solid fa-bars"></i>
            <a id='home_icon' href='../<?=strtolower($type)?>/index.php'><i class="fa-solid fa-house"></i></a>
            <a id='logout_icon' href='../<?=strtolower($type)?>/logout.php'><i class="fa-solid fa-right-from-bracket"></i></a>
			<input type='hidden' id='mail_type' value='<?=$type?>'>
        </div>
	</header>
    <aside class='sidebar'>
        <div class='header'>
			<figure>
                <?php if ($type == 'admin') {?>
                    <figcaption>ADMINISTRATOR</figcaption>
                    <i class="fa-solid fa-user fa-8x"></i>
                <?php } else {
                    $info = Database::check_unique_username($username, $type.'s', 1);
                    $name = $info[$type.'_first_name'].' '.$info[$type.'_last_name']
                    ?>
                    <figcaption><?=$name?></figcaption>
                    <img src='../bin/st_sidebar_img.php?id=<?=$info[$type.'_id']?>&t=<?=$type?>' alt='<?=$info[$type.'_first_name']?> <?=$info[$type.'_last_name']?>'>
                <?php }?>
            </figure>
        </div>
        <nav>
            <ul><?= create_sidebar('mailbox', $type, $username);?></ul>
        </nav>
    </aside>
	<main>
        <?=check_js_enabled();?>
        <section class='mails mails_forms'>
			<h3>SEND MAIL</h3>
            <?=handle_session_errors();?>
			<article class='send_mail'>
            <?php 
			if (!isset($_POST['send_mail_su'])) {
				echo $form->dec_type();
			} else {
				if (isset($array) && $array == false) $array = [];
				echo $form->dec_form($rec_type, $array);
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
<script src='../js/guidelines.js'></script>
<script src='../js/fill_title.js'></script>
<script>
    //following snippet shows passport guidelines
	<?php if (isset($_POST['send_mail_su'])) {?>
		let visible = false;
		if (document.querySelector('span.guidelines_icon.mail_usernames')) {
			document.querySelector('span.guidelines_icon.mail_usernames').addEventListener('click', function (e){
				e.stopPropagation();
				e.preventDefault();
				show_guidelines(this, 'usernames');
			})
		}
		document.querySelector('span.guidelines_icon.appendage').addEventListener('click', function (e){
			e.stopPropagation();
			e.preventDefault();
			show_guidelines(this, 'appendage');
		})

		// following snipper auto fills mail title based on receipient type
		form = document.querySelector('form.compose_mail');
		let type = Array.from(form.elements).find(e => e.name == 'regarding')
		if (type) {
			if (type.value == 'class_teacher') {
				form.querySelector('[name=mail_title]').value = `Regarding: <?=Database::check_unique_username($username, 'students', 1)['student_class']?>.`;
			} else if (type.value == 'subject_teacher') {
				form.querySelector('[name=receipient]').addEventListener('change', function (e) {
					let subject = Array.from(form.querySelector('[name=receipient]').options).find(e => e.selected);
					subject = String(subject.innerText).split('-')[1].trim();
					form.querySelector('[name=mail_title]').value = `Regarding: <?=Database::check_unique_username($username, 'students', 1)['student_class']?> ${subject}.`;
				})
    		} else {
				form.querySelector('[name=receipient]').addEventListener('change', function (e) {auto_fill_title(form, type.value)});
			}
		}
	<?php } ?>
</script>
</html>