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
$classes = Database::check_if_subject_exists($subject, 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sub_choose_teachers'])) {
	$teachers = [];
	foreach ($_POST as $key => $value) {
		if (preg_match('/[0-9]/', $key)) $teachers[$key] = $value;
	}
	$set_teacher = new Set_Teacher('subject', $subject, $teachers);//declared in contr.php
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
	<title>SET SUBJECTS TEACHERS</title>
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
        <section class='forms set_sub_teachers_forms'>
            <h3>SET TEACHERS THAT TEACH <?=strtoupper($subject)?></h3>
			<?=handle_session_errors();?>
			<article class='choose_tables teachers'>
			<?php 
			if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sub_choose_teachers'])) {
				$set_teacher->amalg_add_teacher();
			} else {
				?>
				<p>Select teachers that will be teaching individual classes <?=strtoupper($subject)?>.</p>
				<form method='POST' action='<?=$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']?>'>
					<table>
						<tr><th>CLASSES</th><th>CURRENT SUBJECT TEACHER</th><th>SET SUBJECT TEACHER</th></tr>
						<?php
							$teachers = Database::check_unique_class_role('teacher', 'staffs', 1);

							if (Database::check_unique_class_role('principal', 'staffs', 1)) $teachers = array_merge($teachers, Database::check_unique_class_role('principal', 'staffs', 1));

							if (Database::check_unique_class_role('vice principal', 'staffs', 1)) $teachers =  array_merge($teachers, Database::check_unique_class_role('vice principal', 'staffs', 1));


							$table = '';
							foreach ($classes as $key => $value) {
								if ($key == 'subject_name' || $key == 'classes') continue;
								$table .= '<tr>';
								$table .= '<td>'.strtoupper(str_replace('_', ' ', $key)).'</td>';
								if ($value == NULL) {
									$table .= '<td>NONE</td>';
								} else {
									$name = Database::check_unique_id($value, 'staffs', 1);
									$table .= $name ? '<td>'.$name['staff_first_name'].' '.$name['staff_last_name'].'</td>' : '<td>NONE</td>';
								}
								$table .= '<td><select name=\''.$key.'\'';
								$subs_not_offered = new Get_Subjects($key);
								if (in_array(strtolower($subject), $subs_not_offered->get_infof())) {
									$table .= 'disabled';
								}
								$table .= '>';
								$table .= '<option value =\'\'>---</option>';
								if ($teachers) {
									foreach ($teachers as $teacher) {
										$table .= '<option value =\''.$teacher['staff_id'].'\'';
										if ($teacher['staff_id'] == $value) $table .= 'selected';
										$table .= '>';
										$table .= $teacher['staff_first_name'].' '.$teacher['staff_last_name'];
										$table .= '</option>';
									}
								}
								$table .= '</select></td>';
								$table .= '</tr>';
							}
							echo $table;
						?>
						<tr><td colspan='3'><input type='submit' name='sub_choose_teachers' value='Set teachers'></td></tr>
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
</html>