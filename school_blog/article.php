<?php
require_once '../bin/contr.php';
require_once '../bin/start_session.php';
require_once '../bin/errorlib.php';
require '../bin/page_view.php';
require '../bin/sidebar_items.php';
check_request(['p'], './all_posts.php');

$id = $_GET['p'];
$post = new Mod_Blog();
$post = $post->retrieve_post($id);
$recent_posts = new Mod_Blogs();
$recent_posts = $recent_posts->retrieve_posts(1);

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
	<title><?=strtoupper($post['post_title'])?></title>
</head>
<body>
    <header>
        <div id='header_div' class='fa-xl'>
            <div id='motto'>If education is exspensive, try ignorance.</div>
            <i id='sidebar_control' class="fa-solid fa-bars"></i>
        </div>
	</header>
    <aside class='sidebar'>
        <p>Recent posts:</p>
        <ul id='recent_posts_list' class='aside_list'>
        <?php
        foreach ($recent_posts as $recent) {
            echo '<li><a href=\'./article.php?p='.$recent['post_id'].'\'>'.$recent['post_title'].'</a></li>';
        }
        ?>
        </ul>
    </aside>
	<main>
        <?=check_js_enabled();?>
        <section class='blog'>
            <article class='blog_post'>
                <h3><?=$post['post_title']?></h3>
                <?if ($post['file_type'] && is_file('./posts/images/'.trim($post['post_id']).'.'.trim($post['file_type']))) {?>
                    <figure>
                        <img src='./image.php?id=<?=$post['post_id']?>&type=<?=$post['file_type']?>'>
                    </figure>
                <?php }?>
                <div class='article_content'><?=evaluateText($post['post_content'])?></div>
                <div class='post_time'>Posted: <?=$post['post_date']?></div>
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