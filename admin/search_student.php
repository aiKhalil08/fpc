<?php
require_once '../bin/start_session.php';
require '../bin/page_view.php';
require '../bin/contr.php';
require '../bin/view.php';
require '../bin/sidebar_items.php';
ob_start();
check_login('admin_username', './login.php');
if (isset($_POST['search'])) {
	check_request(['method'], './index.php');
	$req = $_GET['method'];
	switch ($req) {
		case 'lc':
			$method = 'class';
			$input = $_POST['class'];
			break;
		case 'us':
			$method = 'surname';
			$input = $_POST['surname'];
			break;
		case 'su':
			$method = 'username';
			$input = $_POST['username'];
			break;
		default:
			header('location: ./index.php');
			die();
			break;
	}
	$search = new Search_St('student', $method, $input);//declared in contr.php
	$result = $search->search();
	$view = new Display_All_St($result, 'student');//declared in view.php
}
?>
<!doctype html>
<html>
<head>
	<script src='../js/classes_roles.js'></script>
	<script src='../js/create_search_input_field.js'></script>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && sizeof($result) > 0) {
		echo '<meta name=\'viewport\' content=\'width=device-width, initial-scale=.5\'>';
	} else {
		echo '<meta name=\'viewport\' content=\'width=device-width, initial-scale=1\'>';
	}
	?>
	<link rel="stylesheet" href="../style/style.css">
	<!-- <script src="https://kit.fontawesome.com/39a92e8fbb.js" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="../style/fontawesome/css/all.css">
	<title>SEARCH STUDENT</title>
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
		<section class='forms search_forms'>
            <h3>SEARCH FOR STUDENT</h3>
			<?=handle_session_errors();?>
			<article class='input'>
			<form method='post' action='./search_student.php' class='search_form'>
				<?php 
				if (!isset($_POST['search'])) {
				?>
					<p>Choose parameter to search by:</p>
					<p>
						<label>Search student by: </label>
						<select name="search_par" id="search_par">
							<option value="">---</option>
							<option value="lc">class</option>
							<option value="us">surname</option>
							<option value="su">username</option>
						</select>
					</p>
					<?php
				} else if (isset($_POST['search'])) {
					$methods = array('class' => 'lc', 'surname' => 'us', 'username' => 'su');
				?>
					<p>Choose parameter to search by:</p>
					<p>
						<label>Search student by: </label>
						<select name="search_par" id="search_par">
							<option value="">---</option>
							<?php
							foreach ($methods as $key => $value) {
								echo '<option value=\''.$value.'\'';
								if ($_POST['search_par'] == $value) {
									echo 'selected';
								}
								echo '>'.$key;
							}
							?>
						</select>
					</p>
				<script>
				createInputField(document.querySelector('form.search_form'), '<?=$_POST["search_par"]?>', '<?=$_POST["input"]?>', 'student');
				</script>
				<?php } ?>
				<p id='sub'><input type="submit" name="search" id="sel_search_par" value='Search'></p>
			</form>
			</article>
		</section>
		<article class='output info_tables all_sts'>
		<?php if (isset($_POST['search'])) echo $view->create_view(); ?>
		</article>
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
	document.querySelector('form.search_form #search_par').addEventListener('change', function (e) {
		let selected = Array.from(this.options).find(option => option.selected == true);
		createInputField(this.form, selected.value, false, 'student');
	});
</script>
</html>