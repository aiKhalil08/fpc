<?php
require_once '../bin/start_session.php';
require '../bin/page_view.php';
require '../bin/contr.php';
require '../bin/view.php';
require '../bin/sidebar_items.php';
ob_start();
check_login('staff_username', './login.php');
check_request(false, './subjects.php');


if (!isset($_POST['add_results_sub']) && !isset($_POST['fallback_submit'])) {
	if (empty($_POST['result_type'])) {
		$_SESSION['errors'] = ['Please select a result type.'];
		header('location: ./add_results.php?c='.base64_encode($_POST['subject_class']));
		die();
	}
	$subject_class = $_POST['subject_class'];
	$subject_class = explode('-', $subject_class);
	$subject = trim($subject_class[0]);
	$class = trim($subject_class[1]);
	$result_type = $_POST['result_type'];
	$session = $_POST['session'];
	$term = $_POST['term'];
	
	$check = new Check_Class_Result($subject, $class, $session, $term, $result_type, 1, 'subject');//checks if result for class exists. declared in contr.php
	$students = $check->amalg_check_class_result();//returns true if result for selected class exists
	
	$add_res_from = new Dec_Input_Results($students, $subject, $class, $session, $term, $result_type);//declared in view.php. declares 	form where result in inputted
} else {
	$ids = $_POST['id'];
	$scores = $_POST['score'];
	$subject = $_POST['subject'];
	$class = $_POST['class'];
	$session = $_POST['session'];
	$term = $_POST['term'];
	$res_type = $_POST['res_type'];
	$add = new Add_Results($ids, $scores, $subject, $class, $session, $term, $res_type);//declared in contr.php. adds students results
}


?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='viewport' content='width=device-width, initial-scale=.5'>
	<link rel="stylesheet" href="../style/style.css">
    <!-- <script src="https://kit.fontawesome.com/39a92e8fbb.js" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="../style/fontawesome/css/all.css">
	<title>ADD RESULTS</title>
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
            <h3><?=$subject?> RESULTS</h3>
			<?=handle_session_errors();?>
		    <?php
			if (!isset($_POST['add_results_sub']) && !isset($_POST['fallback_submit'])) {
				echo $add_res_from->dec_form(); 	
			} else {
				$add->amalg_add_results();
				$send_type = 'admin';
				$send_username = 'admin';
				$rec_type = 'staff_username';
				$receipient = $_COOKIE['staff_username'];
				$title = 'UPDATE OF '.strtoupper($class).' '.strtoupper($subject).' RESULTS.';
				$mail = 'Hi '.$_COOKIE['staff_first_name'].'.
				This is to inform you that the results of the following class and subject was edited at '.date('h:i A, d M, Y').'.
				CLASS: '.strtoupper($class).'
				SUBJECT: '.strtoupper($subject).'.
				Please disregard this mail if you are aware of the change.';
				$send_mail = new Send_Mail($send_type, $send_username, $rec_type, $receipient, $title, $mail);//declared in contr.php
				$send_mail->amalg_send_mail();
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
<script src='../js/password_prompt.js'></script>
<script>
    document.querySelector('[name=add_results_sub]').addEventListener('click', function (e) {
        password_prompt(e, `<?=$_COOKIE['staff_last_name']?>`, this.form);
    });
</script> 
</html>