<?php
require_once '../bin/contr.php';
require_once '../bin/start_session.php';
require_once '../bin/errorlib.php';
require '../bin/page_view.php';
require '../bin/sidebar_items.php';
check_login('student_username', './login.php');


$error = false;
try {
    $posts = new Mod_Blogs();
    $count = $posts->count_posts();
    $posts = $posts->retrieve_posts();
    $schoolInfo = schoolInfo();
} catch (Exception $e) {
    $error = true;
}

$id = $_COOKIE['student_id'];
$bio = new Get_St_InfoBio($id, 'student');
$info = $bio->get_infobio();

$class = $info['student_class'];
$class_teacher = new Get_Classes_Info($class);//gets class teacher for student. declared in contr.php
$class_teacher = $class_teacher->get_infof();
$info['class_teacher'] = $class_teacher;
$student_info = array();
foreach ($info as $key => $value) {
	$student_info[$key] = $value;
}

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
	<title><?=$_COOKIE['student_first_name']?> <?=$_COOKIE['student_last_name']?></title>
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
            <a href='./student_bio.php'>
            <figure>
                <figcaption><?=$_COOKIE['student_first_name']?> <?=$_COOKIE['student_last_name']?></figcaption>
                <img src='../bin/st_sidebar_img.php?id=<?=$_COOKIE['student_id']?>&t=student' alt='<?=$_COOKIE['student_first_name']?> <?=$_COOKIE['student_last_name']?>'>
            </figure>
            </a>
        </div>
        <nav>
            <ul><?= create_sidebar('student');?></ul>
        </nav>
    </aside>
	<main>
        <?=check_js_enabled();?>
        <section class='index'>
            <article id='school_info'>
                <header><h3>STUDENT AND SCHOOL INFO</h3></header>
                <div>
                    <div id='student_basic_info_box'>
						<span id='passport'>
							<img src='<?=$student_info['student_passport']?>' alt='<?=strtoupper($student_info['student_first_name'])?>'>
						</span>
						<div id='names'>
							<div><span>Student's first name: </span><span><?=strtoupper($student_info['student_first_name'])?></span></div>
							<div><span>Student's last name: </span><span><?=strtoupper($student_info['student_last_name'])?></span></div>
							<div><span>Student's class: </span><span><?=strtoupper($student_info['student_class'])?></span></div>
							<div><span>Student's gender: </span><span><?=strtoupper($student_info['student_gender'])?></span></div>
						</div>
					</div>
                    <p><span>Class teacher: </span><span><?=$student_info['class_teacher']?></span></p>
                    <p><span>Current session: </span><span><?=$schoolInfo['current_session']?></span></p>
                    <p><span>Current term: </span><span><?=$schoolInfo['current_term']?></span></p>
                    </span>
                </div>
            </article>
			<?php if (!$error) {?>
            <article id='school_blog'>
                <header><h3>SCHOOL BLOG</h3></header>
                <div id='posts_slide'>
                <?php
                if (count($posts) > 0) {
                    echo '<span id=\'prev_slide\'>&#x276c;</span>';
                    echo '<span id=\'next_slide\'>&#x276d;</span>';
                    foreach($posts as $post) {
                        echo '<article class=\'slide post_slide\'>';
                        echo '<a href=\'../school_blog/article.php?p='.$post['post_id'].'\' target=\'_blank\'>';
                        if (is_file('../school_blog/posts/images/'.$post['post_id'].'.'.$post['file_type'])) {
                        echo '<img src=\'../school_blog/image.php?id='.$post['post_id'].'&type='.$post['file_type'].'\' alt=\''.$post['post_title'].'\'>';
                        }
                        echo '<h4>'.$post['post_title'].'</h4>';
                        echo '<div class=\'article_content\'>'.evaluateText($post['subcontent']).'continue reading...</div>';
                        echo '<div class=\'post_time\'>Posted: '.$post['post_date'].'</div>';
                        echo '</a>';
                        echo '</article>';
                    }
                    echo '<div id=\'dots_bar\'><div>';
                    for($i = 0; $i < count($posts); $i++) {
                        echo '<span class=\'dots\'></span>';
                    }
                    echo '</div></div>';
                } else {
                    echo '<strong>NO BLOG POSTS.</strong>';
                }
                ?>
                </div>
            </article> <?php }?>
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
<script src='../js/posts_slide.js'></script>
<script>
<?php if (count($posts) > 0) {
    ?>create_slide_show(document.querySelector('div#posts_slide'), 10000);<?php
}?>
</script>
</html>