<?php
require_once '../bin/contr.php';
require_once '../bin/start_session.php';
require_once '../bin/errorlib.php';
require '../bin/page_view.php';
require '../bin/sidebar_items.php';
ob_start();
check_login('admin_username', './login.php');
check_request(false, './index.php');
check_request(['pe'], './index.php');



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$basic_info = array_slice($_POST, 0, sizeof($_POST) - 1);
	$_SESSION['basic_info'] = $basic_info;
} else {$basic_info = array_key_exists('basic_info', $_SESSION) ? ($_SESSION['basic_info']) : false;}

$req = $_GET['pe'];
if ($req == 'tn') {
	$type = 'student';
} else if ($req == 'fa') {
	$type = 'staff';
}
$username = trim($basic_info[$type.'_username']);
if (!$basic_info['existing'] && !Database::check_unique_username($username, $type.'s')) {
	Error_Reg::set_errors('S'.substr($type, 1).' with username already exists.');
	Error_Reg::set_err_session();
	header('location: ./add'.$type.'.php');
	die();
} else if ($basic_info['existing'] && !Database::check_unique_username($username, $type.'s')) {
    if (strtoupper($username) != Database::check_unique_id($basic_info['id'], $type.'s', 1)[$type.'_username']) {
        Error_Reg::set_errors('S'.substr($type, 1).' with username already exists.');
        Error_Reg::set_err_session();
        header('location: ./add'.$type.'.php?id='.$basic_info['id']);
        die();
    }
}
$array = false;
if ($basic_info['existing']) {
	$obj = new Get_Bio($type, $basic_info['id']);//declared in contr.php
	$array = $obj->get_biof();
}
$add_obj = new Dec_Editst_Bio($type, $basic_info['existing'], $array);//declared in page_view.php
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
            <?=handle_session_errors();?>
            <article>   
                <p>Fill the following form appropriately to add <?=$type?>'s biodata.</p>
                <p>* Any mistake that occurs during the registration can only be rectified after the registration is complete.</p>
                <form method='post' action='./editst_bio.php' class='reg_form' enctype='multipart/form-data'>
                    <?php
                    echo $add_obj->dec_addst_bio();
                    ?>
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
<script src='../js/guidelines.js'></script>
<script>
    //following snippet validates form inputs
    let error;
    let form = document.querySelector('[class=reg_form]');
    Array.from(form.elements).forEach(input => {
        if (input.type != 'hidden' && input.type != 'submit' && input.type != 'fieldset') {
            let type = 'general';
            if (input.name == 'parent_name' || input.name == 'nok_name') type = 'only_string';
            if (['parent_phone','staff_phone','nok_phone'].includes(input.name)) type = 'length';
            input.addEventListener('change', function (e) {validate(e, type, this, {length: 14})});
        }
    })
    let excepteds_array = [];
    if (`<?=$type?>` == 'student') excepteds_array.push('parent_email');
    if (`<?=$basic_info['existing']?>` == true) excepteds_array.push(`<?=$type?>_passport`);  
    form.elements.editst_submit.addEventListener('click', function (e) {check_fields_filled(e, this, excepteds_array)});

    //following snippet shows passport guidelines
    let visible = false;
	document.querySelector('span.guidelines_icon').addEventListener('click', function (e){
		e.stopPropagation();
		e.preventDefault();
		show_guidelines(this, 'passport');
	})
</script>
</html>