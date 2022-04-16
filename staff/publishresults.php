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
if (!isset($_POST['pub_sub'])) {
	$class = $_POST['class'];
	if (Error_Reg::check_class_role($class, 'students')) {
		echo '<h3>THE SELECTED CLASS IS EMPTY.</h3>';
	} else {
		$period = Set_Session::get_cur_sess_term();
		$session = $period['session'];
		$term = $period['term'];
		$results = new Get_Unpublished_Results($class, $session, $term);//declared in contr.php. gets all subjects taught by teacher
		$results = $results->amalg_get_unpublished_results();
		$pub_res = new Dec_Choose_Publish($results);//declared in page_view.php
		$pub_res->dec_form();	
	}
} else if (isset($_POST['pub_sub'])) {
	if (isset($_POST['to_publish'])) {
		if (sizeof($_POST['to_publish']) < 1) {
			$_SESSION['errors'] = 'PLEASE SELECT RESULTS TO PUBLISH.';
			header('location: ./publish_results.php');
			die();
		}
		$results = $_POST['to_publish'];
		$string = '';
		foreach ($results as $result) {
			$string .= $result.'&';
		}
		$results = $string;
	} else if (isset($_POST['check_all'])) {
		if ($_POST['check_all'] == '') {
			$_SESSION['errors'] = 'PLEASE SELECT RESULTS TO PUBLISH.';
			header('location: ./publish_results.php');
			die();
		}
		$results = $_POST['check_all'];
	}
	$authenticate = new Dec_Authenticate_Publish($results);//declared in page_view.php
	$authenticate->dec_form();
}
show_footer();
?>