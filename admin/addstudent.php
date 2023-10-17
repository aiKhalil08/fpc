<?php
require_once '../bin/contr.php';
require_once '../bin/start_session.php';
require_once '../bin/errorlib.php';
require '../bin/page_view.php';
require '../bin/sidebar_items.php';
ob_start();
check_login('admin_username', './login.php');
$existing = false;
$array = false;
if (@$_REQUEST['id']) {
    $id = $_GET['id'];
    if (Database::check_unique_id($id, 'students')) {
        header('location: ./index.php');
        die();
    }
	$existing = true;
	$obj = new Get_Info('student', $id);//declared in contr.php
	$array = $obj->get_infof();
}
$add_obj = new Dec_Addst('student', $existing, $array);//declared in page_view.php
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
	<title>ADD STUDENT</title>
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
		<section class='forms add_forms'>
            <h3>STUDENT REGISTRATION</h3>
            <?=handle_session_errors();?>
            <article>
                <p>Fill the following form appropriately to register a new student.</p>
                <p>* Any mistake that occurs during the registration can only be rectified after the registration is complete.</p>
                <form method='post' action='./edit_bio.php?pe=tn' class='reg_form'>
                    <fieldset>
                        <legend>Sudent registration</legend>
                        <?=$add_obj->dec_addst();?>
                    </fieldset>
                </form>
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
<script src='../js/f_validate.js'></script>
<script>
    let error;
    let form = document.querySelector('[class=reg_form]');
    Array.from(form.elements).forEach(input => {
        if (input.type != 'hidden' && input.type != 'submit' && input.type != 'fieldset') {
            let type = 'general';
            if (input.name == 'student_first_name' || input.name == 'student_last_name') type = 'only_string';
            input.addEventListener('change', function (e) {validate(e, type, this)});
        }
    })
    form.elements.addst_submit.addEventListener('click', function (e) {check_fields_filled(e, this)});
</script>
</html>