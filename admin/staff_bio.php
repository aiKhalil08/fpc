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
$bio = new Get_St_InfoBio($id, 'staff');//declared in contr.php
$result = $bio->get_infobio();
$classes = new Get_Class_Students_For_Teacher($result['staff_username']);//gets classes which staff is the class teacher of. declared in contr.php;
$classes = $classes->get();
$subjects = new Get_Subject_Classes_For_Teacher($result['staff_username']);//gets subjects which staff teaches. declared in contr.php;
$subjects = $subjects->get();
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
	<title><?=$result['staff_first_name'].' '.$result['staff_last_name'];?></title>
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
            <h3><?=$result['staff_first_name'].' '.$result['staff_last_name'];?></h3>
			<?=handle_session_errors();?>
            <section class='basic_info field_set'>
                <span class='legend'>Basic info </span>
                <article id='passport'>
                    <img src=<?=$result['staff_passport']?> alt='<?=strtoupper($result['staff_first_name'])?>'>
                </article>
                <article class='names'>
                    <div><span>staff's first name: </span><span><?=strtoupper($result['staff_first_name'])?></span></div>
                    <div><span>staff's last name: </span><span><?=strtoupper($result['staff_last_name'])?></span></div>
                    <div><span>staff's username: </span><span><?=strtoupper($result['staff_username'])?></span></div>
                    <div><span>staff's role: </span><span><?=strtoupper($result['staff_role'])?></span></div>
                    <div><span>staff's gender: </span><span><?=strtoupper($result['staff_gender'])?></span></div>
                </article>
            </section>
            <section class='bio_info field_set'>
                <span class='legend'>Further info </span>
                <article id='more_info' class='names'>
                    <div><span>Staff's phone number: </span><span><?=strtoupper($result['staff_phone_number'])?></span></div>
                    <div><span>Staff's email address: </span><span><?=strtoupper($result['staff_email'])?></span></div>
                    <div><span>Next of kin's name: </span><span><?=strtoupper($result['nok_name'])?></span></div>
                    <div><span>Next of kin's phone number: </span><span><?=strtoupper($result['nok_phone_number'])?></span></div>
                    <div><span>staff's religion: </span><span><?=strtoupper($result['staff_religion'])?></span></div>
                    <div><span>staff's date of birth: </span><span><?=strtoupper($result['staff_dob'])?></span></div>
                    <div><span>staff's state of origin: </span><span><?=strtoupper($result['staff_storg'])?></span></div>
                    <div><span>Residential address: </span><span><?=strtoupper($result['staff_address'])?></span></div>
                </article>
            </section>
            <section class='classes field_set'>
                <span class='legend'>Classes </span>
                <article id='classes' class='names'>
                    <p><?=$result['staff_first_name'].' '.$result['staff_last_name'];?> is the class teacher of the following classes: </p>
                    <?php
                    if (!$classes) {
                        echo 'NONE';
                    } else {
                        echo '<ul>';
                        foreach ($classes as $class) {
                            echo '<li><a href = \'./class_info.php?c='.base64_encode(trim($class)).'\'>'.$class.'</a></li>';
                        }
                        echo '</ul>';
                    }
                    ?>
                </article>
            </section>
            <section class='subjects field_set'>
                <span class='legend'>Subjects </span>
                <article id='subjects' class='names'>
                    <p><?=$result['staff_first_name'].' '.$result['staff_last_name'];?> teaches the following subjects: </p>
                    <?php
                    if (!$subjects) {
                        echo 'NONE';
                    } else {
                        echo '<ul>';
                        foreach ($subjects as $subject) {
                            echo '<li>'.$subject.'</li>';
                        }
                        echo '</ul>';
                    }
                    ?>
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