<?php
require_once '../bin/start_session.php';
require '../bin/page_view.php';
require '../bin/contr.php';
require '../bin/view.php';
require '../bin/sidebar_items.php';
ob_start();
check_login('admin_username', './login.php');
$subjects = Database::get_all_subjects(1);
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='viewport' content='width=device-width, initial-scale=.5'>
	<link rel="stylesheet" href="../style/style.css">
    <script src='../js/password_prompt.js'></script>
    <!-- <script src="https://kit.fontawesome.com/39a92e8fbb.js" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="../style/fontawesome/css/all.css">
	<title>VIEW CURRICULUM</title>
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
        <section class='info_tables'>
            <h3>SCHOOL CURRICULUM</h3>
            <article class='curriculum_tables'>
                <table>
                    <tr><th>S/N</th><th>SUBJECT</th><th>CLASSES</th><th>EDIT CLASSES</th><th>SET TEACHERS</th></tr>
                    <?php
                    $table = '';
                    for ($i = 0; $i < sizeof($subjects); $i++) {
                        $table .= '<tr>';
                        $table .= '<td>'.($i + 1).'.</td>';
                        $table .= '<td>'.strtoupper($subjects[$i]['name']).'</td>';
                        $table .= empty($subjects[$i]['classes']) ? '<td>NONE</td>' : '<td>'.strtoupper(str_replace(',', ', ', $subjects[$i]['classes'])).'</td>';
                        $table .= '<td><a href=\'././set_class_subjects.php?s='.base64_encode($subjects[$i]['name']).'\'>EDIT CLASSES...</td>';
                        $table .= '<td><a href=\'./set_subject_teacher.php?s='.base64_encode($subjects[$i]['name']).'\'>SET TEACHERS...</td>';
                        $table .= '</tr>';
                    }
                    echo $table;
                    ?>
                </table>
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
</html>