<?php
require_once '../bin/start_session.php';
require '../bin/page_view.php';
require '../bin/contr.php';
require '../bin/view.php';
require '../bin/sidebar_items.php';
ob_start();
check_login('admin_username', './login.php');
check_request(['id'], './index.php');
$id = @$_GET['id'];
$bio = new Get_St_InfoBio($id, 'student');
$result = $bio->get_infobio();
$class = class_info($result['student_class']);
$period = Set_Session::get_cur_sess_term();
$session = $period['session'];
$student_subjects = new Get_Session_Subjects_For_Student($id, $session);
$student_subjects = $student_subjects->get_infof();
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<link rel="stylesheet" href="../style/style.css">  
    <script src='../js/password_prompt.js'></script>
    <!-- <script src="https://kit.fontawesome.com/39a92e8fbb.js" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="../style/fontawesome/css/all.css">
	<title><?=$result['student_first_name'].' '.$result['student_last_name'];?></title>
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
        <section class='forms st_bio_forms'>
            <h3><?=$result['student_first_name'].' '.$result['student_last_name'];?></h3>
			<?=handle_session_errors();?>
            <section class='basic_info field_set'>
                <span class='legend'>Basic info </span>
                <article id='passport'>
                    <img src='<?=$result['student_passport']?>' alt='<?=strtoupper($result['student_first_name'])?>'>
                </article>
                <article class='names'>
                    <div><span>Student's first name: </span><span><?=strtoupper($result['student_first_name'])?></span></div>
                    <div><span>Student's last name: </span><span><?=strtoupper($result['student_last_name'])?></span></div>
                    <div><span>Student's username: </span><span><?=strtoupper($result['student_username'])?></span></div>
                    <div><span>Student's class: </span><span><?=strtoupper($result['student_class'])?></span></div>
                    <div><span>Student's gender: </span><span><?=strtoupper($result['student_gender'])?></span></div>
                </article>
            </section>
            <section class='bio_info field_set'>
                <span class='legend'>Further info </span>
                <article id='more_info' class='names'>
                    <div><span>Parent's / Guardian's name: </span><span><?=strtoupper($result['parent_name'])?></span></div>
                    <div><span>Parent's / Guardian's phone number: </span><span><?=strtoupper($result['parent_phone_number'])?></span></div>
                    <div><span>Parent's / Guardian's email: </span><span><?=strtoupper($result['parent_email'])?></span></div>
                    <div><span>Student's religion: </span><span><?=strtoupper($result['student_religion'])?></span></div>
                    <div><span>Student's date of birth: </span><span><?=strtoupper($result['student_dob'])?></span></div>
                    <div><span>Student's state of origin: </span><span><?=strtoupper($result['student_storg'])?></span></div>
                    <div><span>Residential address: </span><span><?=strtoupper($result['student_address'])?></span></div>
                </article>
            </section>
            <section class='class_info field_set'>
                <span class='legend'>Class info </span>
                <article id='class_info' class='names'>
                    <div><span>Class name: </span><span><?=strtoupper($class->get_class_name())?></span></div>
                    <div><span>Class teacher: </span><span><?php
                    echo $class->get_class_teacher() ? '<a href=\'./staff_bio.php?id='.$class->get_class_teacher()['id'].'\'>'.$class->get_class_teacher()['name'].'</a>' : 'NONE';
                    ?></span></div>
                    <div><span>Number of students in class: </span><span><?=$class->student_count()?></span></div>
                    <div><span>View class: </span><span><a href='./class_info.php?c=<?=base64_encode(trim($class->get_class_name()))?>'>CLASS INFO</a></span></div>
                </article>
            </section>
            <section class='subjects_info field_set'>
                <span class='legend'>Subjects info </span>
                <article id='subjects_info' class='names'>
                    <div><span>Student's registration status: </span><span><?=sizeof($student_subjects) == 0 ? 'Not registred' : 'Registered';?></span></div>
                    <div><span>Number of subjects offered: </span><span><?=sizeof($student_subjects);?></span></div>
                    <div><span>All subjects offered: </span><span><?php
                    if (sizeof($student_subjects) == 0) {
                        echo 'NONE';
                    } else {
                        echo '<ul>';
                        foreach ($student_subjects as $subject) {
                            echo '<li>'.$subject.'</li>';
                        }
                        echo '</ul>';
                    }
                    ?></span></div>
                </article>
            </section>
            <article class='homepage'><div><a href='./index.php'>GO TO HOMEPAGE</a></article>
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