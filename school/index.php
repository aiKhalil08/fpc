<?php
require_once '../bin/contr.php';
require_once '../bin/start_session.php';
require_once '../bin/errorlib.php';
require '../bin/page_view.php';
require '../bin/sidebar_items.php';

$error = false;
try {
    $posts = new Mod_Blogs();
    $count = $posts->count_posts();
    $posts = $posts->retrieve_posts();
    $schoolInfo = schoolInfo();
} catch (Exception $e) {
    $error = true;
}
$images = file('./school_images.txt');
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
	<title>FOCAL POINT COLLEGE</title>
</head>
<body>
    <header>
        <div id='header_div' class='fa-xl'>
            <div id='motto'>If education is exspensive, try ignorance.</div>
            <i id='sidebar_control' class="fa-solid fa-bars"></i>
        </div>
	</header>
    <aside class='sidebar school_index_sidebar'>
        <nav>
            <ul><?= create_sidebar('fpcindex');?></ul>
        </nav>
    </aside>
	<main>
        <?=check_js_enabled();?>
        <section class='school_index'>
            <figure id='school_logo'>
                <img src='./fpclogo.jpeg'>
            </figure>
            <article class='school_info'>
                <p><?=str_repeat('If education is expensive, try ignorance. ', 20) ?></p>
            </article>
            <article id='school_images'>
                <div id='images_slide'>
                <?php
                if (count($images) > 0) {
                    echo '<span id=\'prev_slide\'>&#x276c;</span>';
                    echo '<span id=\'next_slide\'>&#x276d;</span>';
                    echo '<div id=\'dots_bar\'><div>';
                    foreach($images as $image) {
                        echo '<span class=\'dots\'></span>';
                    }
                    echo '</div></div>';
                    foreach($images as $image) {
                        echo '<div class=\'img_slide slide\'>';
                        $caption = trim(explode(',', $image)[1]);
                        $image = trim(explode(',', $image)[0]);
                        echo '<img class=\'school_images\' src=\'./images/'.$image.'\' alt=\''.$caption.'\'>';
                        echo '<p>'.strtoupper($caption).'</p></div>';
                    }
                }
                ?>
                </div>
            </article>
            <article class='school_info'>
                <p><?=str_repeat('Lorem ipsum dolor sit amet', 20) ?></p>
            </article>
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
<script src='../js/posts_slide.js'></script>
<script>
<?php if (count($posts) > 0) {
    ?>create_slide_show(document.querySelector('div#posts_slide'), 10000);<?php
}?>
<?php if (count($images) > 0) {
    ?>create_slide_show(document.querySelector('div#images_slide'), 10000);<?php
}?>
</script>
</html>