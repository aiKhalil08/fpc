<?php
require_once '../bin/contr.php';
require_once '../bin/start_session.php';
require_once '../bin/errorlib.php';
require '../bin/page_view.php';
require '../bin/sidebar_items.php';


if (!isset($_POST['del_submit'])) {
    $set = isset($_GET['s']) ? $_GET['s'] : 0;
    if (!isset($_GET['search']) || empty($_GET['search'])) {
        $posts = new Mod_Blogs($set);
    } else if (isset($_GET['search']) && !empty($_GET['search'])) {
        $posts = new Mod_Blogs($set, trim($_GET['search']));
    }
    $count = $posts->count_posts();
    $posts = $posts->retrieve_posts();
} else if (isset($_POST['del_submit'])) {
    if (isset($_POST['post_ids']) && sizeof($_POST['post_ids']) > 0) {
        $delete = new Mod_Blog_Admin();
    } else {
        $_SESSION['errors'] = ['Please select posts to delete.'];
        header('location: ./delete_posts.php');
        die();
    }
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
	<title>DELETE POSTS</title>
</head>
<body>
    <header>
        <div id='header_div' class='fa-xl'>
            <div id='motto'>If education is exspensive, try ignorance.</div>
            <i id='sidebar_control' class="fa-solid fa-bars"></i>
            <a id='home_icon' href='../admin/index.php'><i class="fa-solid fa-house"></i></a>
            <a id='logout_icon' href='../<?=strtolower($type)?>/logout.php'><i class="fa-solid fa-right-from-bracket"></i></a>
            <input type='hidden' id='mail_type' value='admin'>
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
            <ul><?= create_sidebar('blog');?></ul>
        </nav>
    </aside>
	<main>
        <?=check_js_enabled();?>
        <section class='blog_posts'>
            <?=handle_session_errors()?>
            <?php
            if (isset($_POST['del_submit']) && sizeof($_POST['post_ids']) > 0) {
                if ($delete->delete_posts($_POST['post_ids'])) echo '<strong>SELECTED POSTS HAVE BEEN DELETED.</strong>';
            } else {
                ?>
                <form method='get' action='delete_posts.php' id='post_search'>
                    <input type="search" name='search' placeholder='Search for article...' value='<?=isset($_GET['search']) ? $_GET['search'] : ''?>'> <button name='search_sub'><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
                <?php echo '<h4>Select the posts you want to delete: </h4>';
                if (sizeof($posts) > 0) {
                    echo '<form action=\'delete_posts.php\' method=\'post\' id=\'delete_posts_form\'>';
                    foreach($posts as $post) {
                        echo '<article class=\'blog_posts_item delete_list_item\'>';
                        echo '<input type=\'checkbox\' name=\'post_ids[]\' value=\''.$post['post_id'].'\'>';
                        
                        if (is_file('./posts/images/'.$post['post_id'].'.'.$post['file_type'])) {
                        echo '<img src=\'./image.php?id='.$post['post_id'].'&type='.$post['file_type'].'\'>';
                        }
                        echo '<h4>'.$post['post_title'].'</h4>';
                        echo '<div class=\'article_content\'>'.evaluateText($post['subcontent']).'</div>';
                        echo '<div class=\'post_time\'>'.$post['post_date'].'</div>';
                        echo '</article>';
                    }
                   echo '<p><input type=\'submit\' name=\'del_submit\' value=\'Delete selected\'></p></form>';
                } else {
                    echo '<strong>NO POSTS</strong>';
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
                    echo '<a href=\'./delete_posts.php?s='.$prev.$search_string.'\'><</a>';
                }
                if ($count % 5 != 0) {
                    $links = floor($count / 5);
                } else {
                    $links = $count / 5 - 1;
                }
                for ($i = 0; $i <= $links;) {
                    echo '<a href=\'./delete_posts.php?s='.$i.$search_string.'\' ';
                    echo $i == $set ? 'id = \'active\'' : '';
                    echo '>'.++$i.'</a>';
                }
                if ($set < $links) {
                    $next = $set + 1;
                    echo '<a href=\'./delete_posts.php?s='.$next.$search_string.'\'>></a>';
                }
                echo '</article>';
            }}?>
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