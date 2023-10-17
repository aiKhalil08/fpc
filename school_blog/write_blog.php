<?php
require_once '../bin/contr.php';
require_once '../bin/start_session.php';
require_once '../bin/errorlib.php';
require '../bin/page_view.php';
require '../bin/sidebar_items.php';
check_request(['t'], './index.php');

$type = base64_decode($_GET['t']);


if (!in_array($type, ['admin', 'student', 'staff'])) {
    header('location: ./index.php');
    die();
}

if ($type == 'student' || $type == 'staff') {
    check_request(['u'], './index.php');

    $username = base64_decode($_GET['u']);
    if (Database::check_unique_username($username, $type.'s')) {
        header('location: ./index.php');
        die();
    }
}

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
	<title>WRITE BLOG</title>
</head>
<body>
    <header>
        <div id='header_div' class='fa-xl'>
            <div id='motto'>If education is exspensive, try ignorance.</div>
            <i id='sidebar_control' class="fa-solid fa-bars"></i>
            <a id='home_icon' href='./index.php'><i class="fa-solid fa-house"></i></a>
            <a id='logout_icon' href='../<?=strtolower($type)?>/logout.php'><i class="fa-solid fa-right-from-bracket"></i></a>
            <input type='hidden' id='mail_type' value='<?=$type?>'>
        </div>
	</header>
    <aside class='sidebar'>
        <p>Recent posts:</p>
        <ul id='recent_posts_list'>
        <?php
        foreach ($recent_posts as $recent) {
            echo '<li><a href=\'./article.php?p='.$recent['post_id'].'\' target=\'_blank\'>'.$recent['post_title'].'</a></li>';
        }
        ?>
        </ul>
    </aside>
	<main>
        <?=check_js_enabled();?>
        <section class='write_blog'>
            <?=handle_session_errors()?>
            <h3>COMPOSE A BLOG ARTICLE</h3>
            <p>The article must have a title and a body. Adding an image is optional.<p>
            <form action='./publish_post.php' method='post' enctype='multipart/form-data' id='compose_blog'>
                <label>Article title (not more than 120 characters): </label><br><br>
                <textarea name='article_title' maxlength='120'></textarea>
                <p><label>Article image(not larger than 5MB): </label><br><input type='file' name='article_image'></p>
                <label>Article body : </label><br><br><textarea name='article_body'></textarea>
                <p><input type='submit' name='publish_sub' value='Publish article'></p>
            </form>
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
<script src='../js/password_prompt.js'></script>
<?php

if ($type == 'admin') {
    $password = 'admin1pass';
} else if ($type == 'student' || $type == 'staff') {
    $password = Database::check_unique_username($username, $type.'s', 1)[$type.'_last_name'];
}

?>
<script>
    document.querySelector('input[name=publish_sub]').addEventListener('click', function(e) {password_prompt(e, '<?=$password?>', this.form, 'Are you sure you want to publish this post?')})
</script>
</html>