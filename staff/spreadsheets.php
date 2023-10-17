<?php
require_once '../bin/start_session.php';
require '../bin/page_view.php';
require '../bin/contr.php';
require '../bin/view.php';
require '../bin/sidebar_items.php';
ob_start();
check_login('staff_username', './login.php');
check_request(false, './index.php');

$referer = trim(preg_split('/\?/', basename($_SERVER['HTTP_REFERER']))[0]);
if ($referer == 'subject_results.php') {
	$subject_class = $_POST['subject_class'];
	$subject_class = explode('-', $subject_class);
	$subject = trim($subject_class[0]);
	$class = trim($subject_class[1]);
	$term = $_POST['term'];
	$session = $_POST['session'];
	$result_type = 'all';
	$class_sub = 'subject';	
} else if ($referer == 'class_results.php') {
	if (empty($_POST['term'])) {
		$_SESSION['errors'] = ['Please select a term.'];
		header('location: ./class_results.php?c='.base64_encode($_POST['class']));
		die();
	}
	$subject = $_POST['subject'];
	$class = $_POST['class'];
	$session = $_POST['session'];
	$term = $_POST['term'];
	$result_type = 'all';
	$class_sub = 'class';
}

$check = new Check_Class_Result($subject, $class, $session, $term, $result_type, 1, $class_sub);//checks if result for class exists. declared in contr.php
$results = $check->amalg_check_class_result();//returns true if result for selected class exists

$spreadsheet = new Show_Spreadsheet($results, $subject, $class, $session, $term, $result_type);//declared in view.php. declares 	form where result in inputted

?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<link rel="stylesheet" href="../style/style.css">
	<link rel="stylesheet" href="../style/spreadsheetprint.css"> <!-- print.css holds style for print media -->
    <!-- <script src="https://kit.fontawesome.com/39a92e8fbb.js" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="../style/fontawesome/css/all.css">
	<title><?=$subject?> SPREADSHEET</title>
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
            <h3><?=$subject?> SPREADSHEET</h3>
			<?=handle_session_errors();?>
		    <?php
			echo $spreadsheet->show();
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