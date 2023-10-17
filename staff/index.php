<?php
require_once '../bin/contr.php';
require_once '../bin/start_session.php';
require_once '../bin/errorlib.php';
require '../bin/page_view.php';
require '../bin/sidebar_items.php';
check_login('staff_username', './login.php');


$error = false;
try {
    $posts = new Mod_Blogs();
    $count = $posts->count_posts();
    $posts = $posts->retrieve_posts();
    $schoolInfo = schoolInfo();

    $username = $_COOKIE['staff_username'];
    $classes = new Get_Class_Students_For_Teacher($username);//declared in contr.php. gets all subjects taught by teacher
    $classes = $classes->get();

    $subjects = new Get_Subject_Classes_For_Teacher($username);//declared in contr.php. gets all subjects taught by teacher
    $subjects = $subjects->get();
} catch (Exception $e) {
    $error = true;
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
	<title><?=$_COOKIE['staff_first_name']?> <?=$_COOKIE['staff_last_name']?></title>
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
        <section class='index'>
            <article id='school_info'>
                <header><h3>STAFF AND SCHOOL INFO</h3></header>
                <div>
                    <p><span>Staff's name: </span><span><?=$_COOKIE['staff_first_name'].' '.$_COOKIE['staff_last_name']?></span></p>
                    <p><span>Staff's role: </span><span><?=$_COOKIE['staff_role']?></span></p>
                    <p><span>Current session: </span><span><?=$schoolInfo['current_session']?></span></p>
                    <p id='cur_term'><span>Current term: </span><span><?=$schoolInfo['current_term']?></span></p>
                    <div class='staff_classes'><span>Classes under staff: </span><span>
                    <?php
                    if ($classes) {
                        echo '<ul>';
                        foreach ($classes as $class) {
                            echo '<li>'.$class.'</li>';
                        }
                        echo '</ul>';
                    } else echo 'NONE';
                    ?>
                    </span></div>
                    <div class='staff_classes'><span>Subjects taught by staff: </span><span>
                    <?php
                    if ($subjects) {
                        echo '<ul>';
                        foreach ($subjects as $subject) {
                            echo '<li>'.$subject.'</li>';
                        }
                        echo '</ul>';
                    } else echo 'NONE';
                    ?>
                    </span></div>
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