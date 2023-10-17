<?php
require_once '../bin/start_session.php';
require '../bin/page_view.php';
require '../bin/contr.php';
require '../bin/view.php';
require '../bin/sidebar_items.php';
ob_start();
check_login('admin_username', './login.php');
$current = Set_Session::get_cur_sess_term();//gets current session and term. declared in contr.php
$current_session = $current['session'];
$current_term = $current['term'];
if ($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_POST['sess_submit']) || isset($_POST['fallback_submit']))) {
    $input_session = $_POST['session'];
    $input_term = $_POST['term'];
    $start_date = $_POST['start_date'];
    $set_session = new Set_Session($input_session, $input_term, $start_date);//declared in contr.php
}
$form = new Dec_Set_Session($current_session, $current_term);//declared in page_view.php
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
	<title>SET SESSION AND TERM</title>
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
		<section class='forms set_period_forms'>
            <h3>SET SCHOOL SESSION AND TERM</h3>
            <?=handle_session_errors();?>
			<article class='input'>
                <?=$form->dec_form();?>
            </article>
        </section>
            <?php
            $message = 'Are you sure you want to change the current term';
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_POST['sess_submit']) || isset($_POST['fallback_submit']))) {
                if ($current_session == $input_session) {
                    $message = 'Are you sure you want to change the current term ('.$current_term.') to '.$input_term.'?';
                } else {
                    $message = 'Are you sure you want to chage the current session and term ('.$current_session.' '.$current_term.') to '.$input_session.' '.$input_term.'?';
                }
                echo '<article class=\'output\'>';
                $set_session->change_sess_term();
                echo '</article>';
            }
            ?>
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
    document.querySelector('[name=sess_submit]').addEventListener('click', function (e) {
        password_prompt(e, `<?=$_COOKIE['admin_password']?>`, this.form, `<?=$message?>`);
    });
</script> 
</html>