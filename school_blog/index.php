<?php
require_once '../bin/contr.php';
require_once '../bin/start_session.php';
require_once '../bin/errorlib.php';
require '../bin/page_view.php';
require '../bin/sidebar_items.php';

$set = isset($_GET['s']) ? $_GET['s'] : 0;
if (!isset($_GET['search']) || empty($_GET['search'])) {
    $posts = new Mod_Blogs($set);
} else if (isset($_GET['search']) && !empty($_GET['search'])) {
    $posts = new Mod_Blogs($set, trim($_GET['search']));
}
$count = $posts->count_posts();
$posts = $posts->retrieve_posts();
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
	<title>ALL POSTS</title>
</head>
<body>
    <header>
        <div id='header_div' class='fa-xl'>
            <div id='motto'>If education is exspensive, try ignorance.</div>
            <i id='sidebar_control' class="fa-solid fa-bars"></i>
        </div>
	</header>
    <aside class='sidebar'>
        <p id='write_post_login_link'><a href='./login.php' target='_blank'>Write blog post</a></p>
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
        <section class='blog_posts'>
            <form method='get' action='all_posts.php' id='post_search'>
                <input type="search" name='search' placeholder='Search for article...' value='<?=isset($_GET['post_search']) ? $_GET['search'] : ''?>'> <input type="submit" name='search_sub' value='S'>
            </form>
            <?php
            echo isset($_POST['search_sub']) ? '<h3>POSTS THAT MATCH YOUR SEARCH</h3>' : '<h3>BLOG POSTS</h3>';
            if (count($posts) > 0) {
                foreach($posts as $post) {
                    echo '<article class=\'blog_posts_item\'>';
                    echo '<a href=\'./article.php?p='.$post['post_id'].'\' target=\'_blank\'>';
                    if (is_file('./posts/images/'.$post['post_id'].'.'.$post['file_type'])) {
                    echo '<img src=\'./image.php?id='.$post['post_id'].'&type='.$post['file_type'].'\' alt=\''.$post['post_title'].'\'>';
                    }
                    echo '<h4>'.$post['post_title'].'</h4>';
                    echo '<div class=\'article_content\'>'.evaluateText($post['subcontent']).'continue reading...</div>';
                    echo '<div class=\'post_time\'>Posted: '.$post['post_date'].'</div>';
                    echo '</a>';
                    echo '</article>';
                }
            } else {
                echo '<p>NO POSTS.</p>';
            }
            ?>
            <?php
            if ($count > 5) {
                $search_string = '';
                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $search_string = '&search='.$_GET['search'];
                }
                echo '<article id=\'pages_bar\'>';
                if ($set > 0) {
                    $prev = $set - 1;
                    echo '<a href=\'./all_posts.php?s='.$prev.$search_string.'\'><</a>';
                }
                if ($count % 5 != 0) {
                    $links = floor($count / 5);
                } else {
                    $links = $count / 5 - 1;
                }
                for ($i = 0; $i <= $links;) {
                    echo '<a href=\'./all_posts.php?s='.$i.$search_string.'\' ';
                    echo $i == $set ? 'id = \'active\'' : '';
                    echo '>'.++$i.'</a>';
                }
                if ($set < $links) {
                    $next = $set + 1;
                    echo '<a href=\'./all_posts.php?s='.$next.$search_string.'\'>></a>';
                }
                echo '</article>';
            }?>
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