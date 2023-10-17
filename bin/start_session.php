<?php
if (!isset($_SESSION)) {
	session_start();
}
function check_login($index, $redir_location) {
	if (!isset($_COOKIE[$index])) {
		header('location: '.$redir_location);
		die();
	}
	if ($_COOKIE['user_type'] == 'staff' || $_COOKIE['user_type'] == 'student') {
		if (Database::check_unique_username($_COOKIE[$index], $_COOKIE['user_type'].'s')) {
			header('location: '.$redir_location);
			die();
		}
	}
}
function check_request($index = false, $redir_location) {
	if (!$index) {
		if (empty($_REQUEST)) {
			header('location: '.$redir_location);
			die();
		}
	} else {
		foreach ($index as $i) {
			if (!isset($_REQUEST[$i])) {
				header('location: '.$redir_location);
				die();
			}
		}
	}
}
function check_cookie_enabled() {
	setcookie('test_cookie', 'enabled', time() + 60 * 2);
	if (count($_COOKIE) == 0) {
		echo '<script>alert("Please enable cookies in your browser settings to proceed.")</script>';
	}
}
$cookie_excepts = ['/fpc/school/index.php', '/fpc/school/about_school.php', '/fpc/school/contact_info.php', '/fpc/school/developers_contact.php', '/fpc/school_blog/all_posts.php', '/fpc/school_blog/article.php'];
if (!in_array($_SERVER['PHP_SELF'], $cookie_excepts)) check_cookie_enabled();

function check_js_enabled() {
	echo '<noscript><article>Enabling Javascript is required for this site to run properly. Kindly enable Javacript in your browser.</article></noscript>';
}
?>