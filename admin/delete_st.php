<?php
require_once '../bin/start_session.php';
require '../bin/page_view.php';
require '../bin/contr.php';
require '../bin/view.php';
require '../bin/sidebar_items.php';
ob_start();
check_login('admin_username', './login.php');
check_request(['type', 'usernames'], './index.php');
$type_req = $_GET['type'];
$input = $_POST['usernames'];
switch ($type_req) {
	case 'nt':
		$type = 'student';
		break;
	case 'fa':
		$type = 'staff';
		break;
	default:
		header('location: ./index.php');
		die();
		break;
}
$delete = new Delete_St($type, $input);//declared in contr.php
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
	<title>DELETE <?=strtoupper($type)?></title>
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
		<section class='forms notice_forms'>
		<h3>DELETE <?=strtoupper($type)?></h3>
			<?php 
			if (!isset($_POST['proceed']) && !isset($_POST['fallback_submit'])) {
				$result = $delete->show_info();
				$proceed = new Proceed_Delete($type, $input, $result);//notifies about sts to be deleted. declared in view.php
				$proceed->proceed();
			} else if (isset($_POST['proceed']) || isset($_POST['fallback_submit'])) {
				$delete->delete();
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
	<?php if (!isset($_POST['proceed']) && !isset($_POST['fallback_submit'])) {?>
		let del_form = document.querySelector('form');
		document.querySelector('[type=submit]#delete').addEventListener('click', (e) => password_prompt(e, `<?=$_COOKIE['admin_password']?>`, del_form));
	<?php } ?>
</script>
</html>