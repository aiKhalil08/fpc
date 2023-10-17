<?php
require_once '../bin/start_session.php';
require '../bin/page_view.php';
require '../bin/contr.php';
require '../bin/view.php';
require '../bin/sidebar_items.php';
ob_start();
check_login('staff_username', './login.php');
check_request(false, './index.php');


if (empty($_POST['class'])) {
	$_SESSION['errors'] = ['Please select a class.'];
	header('location: '.$_SERVER['HTTP_REFERER']);
	die();
}
$class = $_POST['class'];
$type = $_POST['type'];
$students = new Get_Info_Class_Role($class, 'students', 1);
$students = $students->get_infof();

?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='viewport' content='width=device-width, initial-scale=.5'>
	<link rel="stylesheet" href="../style/style.css">
    <!-- <script src="https://kit.fontawesome.com/39a92e8fbb.js" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="../style/fontawesome/css/all.css">
	<title>WRITE COMMENTS</title>
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
        <section class='student_results'>
            <h3>WRITE COMMENTS</h3>
			<?=handle_session_errors();?>
			<?php
			$string = '';
            if (!$students) {
				$string .= '<strong>THE SELECTED CLASS IS EMPTY.</strong>';
			} else {
				$period = Set_Session::get_cur_sess_term();
				$session = $period['session'];
				$term = $period['term'];
				$string .= '<p>Class: '.$class.'</p>';
				$string .= '<p>Session: '.$session.'</p>';
				$string .= '<p>Term: '.$term.'</p>';
				if ($type == 'class_teacher') {
					$comm_type = 'Class teacher\'s comments.';
				} else {
					$comm_type = 'Principal\'s comments.';
				}
				$string .= '<p>Comment type: '.$comm_type.'</p>';
				$string .= '<p><em>Note that comments cannot be changed after they have been added.</em></p>';
				$string .= '<form method=\'post\' class=\'com_form\' action=\'./writecomments.php\'>';
				$string .= '<table>';
				$string .= '<tr><th>S/N</th><th>STUDENT\'S NAME</th><th>WRITE COMMENT</th></tr>';
				$index = 1;
				foreach ($students as $student) {
					$string .= '<tr>';
					$string .= '<td>'.$index.'.</td>';
					$name = $student['student_first_name'].' '.$student['student_last_name'];
					$string .= '<td>'.$name.'</td>';
					$existing_comment = @Write_Comments::get_comments($student['student_id'], $session, $term)[$type.'_remark'];
					$string .= '<td><input type=\'hidden\' name=\'student_ids[]\' value=\''.$student['student_id'].'\' / ><textarea name=\'comments[]\' class=\'write_comment_field\' ';
					if (!$existing_comment) {
						$string .= 'placeholder=\'type comment...\'';
					}
					$string .= '>';
					if ($existing_comment) {
						$string .= $existing_comment;
					}
					$string .= '</textarea></td>';
					$string .= '</tr>';
					$index++;
				}
				$string .= '<input type=\'hidden\' name=\'session\' value=\''.$session.'\' />';
				$string .= '<input type=\'hidden\' name=\'term\' value=\''.$term.'\' />';
				$string .= '<input type=\'hidden\' name=\'type\' value=\''.$type.'\' />';
				$string .= '<tr><td colspan=\'3\'><input type=\'submit\' name=\'add_comments_sub\' value=\'Add comments\' /></td></tr>';
				$string .= '</table>';
				$string .= '</form>';
			}
			echo $string;
			?>
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
<script src='../js/f_validate.js'></script>
<script>
    //following snippet validates form inputs
    let error;
    let form = document.querySelector('[class=com_form]');
	Array.from(form.elements).forEach(input => {
        if (input.type != 'hidden' && input.type != 'submit' && input.type != 'fieldset') {
            let type = 'length';
            input.addEventListener('change', function (e) {validate(e, type, this, {length: 120})});
        }
    })
    let excepteds_array = [];
    form.elements.add_comments_sub.addEventListener('click', function (e) {check_fields_filled(e, this, excepteds_array)});
</script>
</html>
