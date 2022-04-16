<?php
require '../bin/page_view.php';
require '../bin/view.php';
require '../bin/contr.php';
check_login('staff_username', './login.php');
show_header('PUBLISH RESULTS');
handle_session_errors();
if (!$_REQUEST) {
	header('location: ./publish_results.php');
	die();
}
$password = $_POST['password'];
if (trim(strtoupper($password)) != trim(strtoupper($_COOKIE['staff_username']))) {
	$_SESSION['errors'] = 'PLEASE INPUT A VALID PASSWORD.';
	header('location: ./publish_results.php');
	die();
}
$results = $_POST['result'];
if (preg_match('/&/', $results)) {
	$results = explode('&', $results);
	$results = array_slice($results, 0, (sizeof($results) - 1));
}
$publish = new Publish_Results($results);//declared in contr.php. gets all subjects taught by teacher
@$publish->amalg_publish_results();
show_footer();
?>