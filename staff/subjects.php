<?php
require_once '../bin/start_session.php';
require '../bin/page_view.php';
require '../bin/contr.php';
require '../bin/view.php';
require '../bin/sidebar_items.php';
ob_start();
check_login('staff_username', './login.php');

$username = $_COOKIE['staff_username'];
$classes = new Get_Subject_Classes_For_Teacher($username);//declared in contr.php. gets all subjects taught by teacher
$classes = $classes->get();
$period = Set_Session::get_cur_sess_term();
$session = $period['session'];
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
	<title>MY SUBJECTS</title>
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
        <section class='info_tables'>
            <h3>ALL SUBJECTS</h3>
			<?=handle_session_errors();?>
            <?php 
            if ($classes) {
                echo '<table class=\'curriculum_tables\'>';
                echo '<tr><th>S/N</th><th>SUBJECTS</th><th>NUMBER OF STUDENTS</th><th>ADD/EDIT RESULTS</th><th>VIEW SPREADSHEET</th></tr>';
                $index = 0;
                foreach ($classes as $class) {
                    $orig_class = $class;
                    $subject = trim(explode('-', $class)[0]);
                    $class = trim(explode('-', $class)[1]);
                    if (Database::get_subject_students(strtolower($subject), $class, $session, 'id')) {
                        $count = count(Database::get_subject_students(strtolower($subject), $class, $session, 'id'));
                    } else {$count = 0;}
                    echo '<tr>';
                    echo '<td>'.++$index.'.</td><td>'.$orig_class.'</td><td>'.$count.'</td><td>';
                    echo $count != 0 ? '<a href=\'./add_results.php?c='.base64_encode($orig_class).'\'>add/edit results...</a>' : '-';
                    echo '</td>';
                    echo '<td><a href=\'./subject_results.php?c='.base64_encode($orig_class).'\'>view spreadsheet...</a></td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else echo '<strong>YOU DO NOT TEACH ANY SUBJECTS.</strong>';
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