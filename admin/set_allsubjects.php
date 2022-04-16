<?php
require '../bin/contr.php';
require '../bin/view.php';
require_once '../bin/start_session.php';
require '../bin/page_view.php';
check_login('admin_username', './login.php');
show_header('SET ALL SUBJECTS');
if (!$_REQUEST) header('location: ./set_all_subjects.php');
$all_subjects = $_POST['all_subjects'];
$set_subjects = new Set_Subjects($all_subjects);//declared in contr.php
$set_subjects->amalg_add_subjects();
?>