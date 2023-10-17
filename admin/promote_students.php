<?php
require_once '../bin/start_session.php';
require '../bin/page_view.php';
require '../bin/contr.php';
require '../bin/view.php';
require '../bin/sidebar_items.php';
ob_start();
check_login('admin_username', './login.php');
$period = Set_Session::get_cur_sess_term();
$period = $period['session'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class = $_POST['class'];
    $students = new Get_Info_Class_Role($class, 'students');//gets all students in selected class
    $students = $students->get_infof();
}
$promoted = Promote_Students::get_promoted($period);//gets array of promoted classes. declared in contr.php
$classes = new Dec_Promote_Classes($promoted);//declares form to choose class to be promoted from. declared in page_view.php
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<link rel="stylesheet" href="../style/style.css">
    <script src='../js/password_prompt.js'></script>
    <!-- <script src="https://kit.fontawesome.com/39a92e8fbb.js" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="../style/fontawesome/css/all.css">
	<title>PROMOTE STUDENTS</title>
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
        <section class='forms promote_forms'>
            <h3>PROMOTE STUDENTS</h3>
            <?=handle_session_errors();?>
            <article class='input'><?=$classes->dec_form();?></article>
            <article class='output choose_tables'>
                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (!$students) {
                        echo '<strong>THE SELECTED CLASS IS EMPTY.</strong>';
                    } else {
                        $promote = new Dec_Choose_Promote($students, $class);//declares form to choose whom to be promoted. declared in view.php
                        echo $promote->dec_form();
                    }
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
<script src='../js/mark_all.js'></script>
<script src='../js/password_prompt.js'></script>
<script>

    if (`<?=$_SERVER['REQUEST_METHOD']?>` == 'POST') {
        let form = document.querySelectorAll('form')[1];
		document.querySelector('[type=submit][name=sub_promote]').addEventListener('click', (e) => password_prompt(e, `<?=$_COOKIE['admin_password']?>`, form));

        if (document.querySelector('form [name=mark_all]')) {
            document.querySelector('form [name=mark_all]').addEventListener('change', function (e){mark_all(e, this);});
            document.querySelectorAll('form [type=checkbox]').forEach(e => e.addEventListener('change', function (e){remove_mark_all(e, this)}));
        }
    }
</script>
</html>