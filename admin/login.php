<?php
require_once '../bin/start_session.php';
require_once '../bin/errorlib.php';
require '../bin/page_view.php';
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	<link rel="stylesheet" href="../style/style.css">
	<link rel="stylesheet" href="../style/fontawesome/css/all.css">
	<title>ADMIN LOGIN</title>
</head>
<body>
	<header>
		<div id='header_div' class='fa-xl'>
            <div id='motto'>If education is exspensive, try ignorance.</div>
        </div>
	</header>
	<div id='main'>
		<section class='login'>
			<?=handle_session_errors();?>
			<article class='login_form'>
				<form method="post" action="loginx.php">
					<p>Log in:</p>
					<p><input type="text" name="admin_username" placeholder='username...'></p>
					<p><input type="password" name="admin_password" placeholder='password...'><i id='show_password' class="fa-solid fa-eye-slash fa-sm"></i></p>
					<p><input type="submit" name="admin_login" value="Login"></p>
				</form>
			</article>
		</section>
	</div>
	<footer id='login_footer'>
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
<script>
// following codes shows or hides password when icon is pressed
document.getElementById('show_password').addEventListener('click', function (e) {
    if (this.previousElementSibling.type == 'password') {
		this.previousElementSibling.type = 'text';
		this.className = 'fa-solid fa-eye fa-sm';
	} else {
		this.previousElementSibling.type = 'password';
		this.className = 'fa-solid fa-eye-slash fa-sm';
	}
})
</script>
</html>