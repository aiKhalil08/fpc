<?php
require_once '../bin/start_session.php';
require '../bin/page_view.php';
require '../bin/contr.php';
require '../bin/view.php';
require '../bin/sidebar_items.php';
ob_start();
check_login('admin_username', './login.php');
check_request(['s'], './index.php');
$subject = base64_decode($_GET['s']);
$classes_offering = Database::read_classes_in_subject($subject);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sub_choose_classes'])) {
	if (isset($_POST['mark_all'])) {
		$classes = 'all';
	} else if (isset($_POST['classes'])) {
		$classes = $_POST['classes'];
	} else $classes = false;
	$set_class_subjects = new Set_Subject_Classes($subject, $classes);//declared in contr.php
}
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
	<title>SET CLASS SUBJECTS</title>
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
        <section class='forms'>
            <h3>SET CLASSES THAT OFFER <?=strtoupper($subject)?></h3>
			<?=handle_session_errors();?>
			<article class='choose_tables classes'>
			<?php 
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sub_choose_classes'])) {
				$set_class_subjects->amalg_add_class_subjects($classes);
			} else {
				?>
				<p>Select classes that will be able to register for <?=strtoupper($subject)?>.</p>
				<p>*Classes that already offer the subject are marked.</p>
				<form method='POST' action='<?=$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']?>'>
					<table>
						<tr><td><b>SELECT ALL</b></td><td><input type='checkbox' name='mark_all' value='all_classes'></td></tr>
						<?php
						$table = '';
						$listed = [];
						foreach (CLASSES as $class) {
							$match = [];
							if (preg_match('/(jss) (\d)\w/i', $class, $match)) {
								if (in_array($match[2], $listed)) continue;
								$listed[] = $match[2];
								$class = $match[1].' '.$match[2];
							}
							$table .= '<tr>';
							$table .= '<td>'.$class.'</td><td><input type=\'checkbox\' name=\'classes[]\' value=\''.$class.'\'';
							$table .= in_array($class, explode(',', $classes_offering)) ? 'checked' : '';
							$table .= '></td>';
							$table .= '</tr>';
						}
						echo $table;
						?>
						<tr><td colspan='2'><input type='submit' name='sub_choose_classes' value='Add classes'></td></tr>
					</table>
					</form>
			<?php }?>
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
<script src='../js/mark_all.js'></script>
<script>
	if ('<?=!isset($_POST['sub_choose_classes'])?>') {
		document.querySelector('form [name=mark_all]').addEventListener('change', function (e){mark_all(e, this);});
		document.querySelectorAll('form [type=checkbox]').forEach(e => e.addEventListener('change', function (e){remove_mark_all(e, this)}));
	}
</script>
</html>