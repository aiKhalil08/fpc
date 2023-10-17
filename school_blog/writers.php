<?php
require_once '../bin/contr.php';
require_once '../bin/start_session.php';
require_once '../bin/errorlib.php';
require '../bin/page_view.php';
require '../bin/sidebar_items.php';

$manage_writers = new Mod_Blog_Admin;
if (isset($_POST['del_submit'])) {
    if (empty($_POST['writers'])) {
        $_SESSION['errors'] = ['Please select writers to delete'];
        header('location: ./writers.php');
        die();
    }
    $manage_writers->delete_writers();
}
if (isset($_POST['set_submit'])) {
    $manage_writers->set_writers($_POST['username'], $_POST['type']);
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
	<title>BLOG WRITERS</title>
</head>
<body>
    <header>
        <div id='header_div' class='fa-xl'>
            <div id='motto'>If education is exspensive, try ignorance.</div>
            <i id='sidebar_control' class="fa-solid fa-bars"></i>
            <a id='home_icon' href='../admin/index.php'><i class="fa-solid fa-house"></i></a>
            <a id='logout_icon' href='../<?=strtolower($type)?>/logout.php'><i class="fa-solid fa-right-from-bracket"></i></a>
            <input type='hidden' id='mail_type' value='<?=$type?>'>
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
        <section class='blog_writers'>
            <h4>BLOG WRITERS</h4>
            <article id='writers_list'>
                <?php 
                echo handle_session_errors();
                ?>
                Only the following personnels are allowed to write a blog:
                <ul id='writers'>
                <i id='show_delete' class="fa-solid fa-trash fa-lg"></i>
                    <li>Admin</li>
                    <?php
                    $existing_writers = $manage_writers->get_writers();
                    foreach ($existing_writers as $writer) {
                        list($username, $type) = explode(',', $writer);
                        $name = Database::check_unique_username($username, $type.'s', 1);
                        $name = $name[$type.'_first_name'].' '.$name[$type.'_last_name'];
                        echo '<li data-username=\''.$username.'\'>'.$name.'</li>';
                    }
                    ?>
                </ul>
            </article>
            <article id='set_writers'> 
                <h5>ADD NEW WRITER</h5>
                <form action='./writers.php' method='post'>
                    <p><label>Choose writer type: </label> 
                        <select name='type'>
                            <option value='staff'>Staff</option>
                            <option value='student'>Student</option>
                        </select>
                    </p>
                    <p><label>Input a username: </label> <input type='text' name='username'></p>
                    <p><input type='submit' name='set_submit' value='Set Writers'></p>
                </form>
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
<script>
    let form_activated = false;
    document.getElementById('show_delete').addEventListener('click', function (e) {
        if (!form_activated) {
            let form = document.createElement('form');
            form.id = 'del_form';
            form.action = './writers.php';
            form.method = 'post';
            Array.from(document.querySelectorAll('ul#writers li')).forEach(li => {
                if (li.textContent != 'Admin') {
                    let checkBox = document.createElement('input');
                    checkBox.type = 'checkbox';
                    checkBox.name = 'writers[]';
                    checkBox.value = li.getAttribute('data-username');
                    li.appendChild(checkBox);
                }
            })
            let submit_button = document.createElement('input');
            submit_button.name = 'del_submit';
            submit_button.type = 'submit';
            submit_button.value = 'Delete';
            let p = document.createElement('p');
            p.appendChild(submit_button);
            form.appendChild(document.querySelector('ul#writers'));
            form.appendChild(p);
            let article = document.querySelector('article#writers_list');
            article.insertBefore(form, article.lastElementChild);
            form_activated = true;
        } else if (form_activated == true) {
            document.querySelector('article#writers_list').replaceChild(document.querySelector('ul#writers'), document.querySelector('form#del_form'));
            Array.from(document.querySelectorAll('ul#writers li')).forEach(li => {
                if (li.textContent != 'Admin') {
                    li.querySelector('input').remove();
                }
            })
            form_activated = false;
        }
    })

</script>
</html>