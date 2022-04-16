<?php
require '../bin/contr.php';
require '../bin/view.php';
require_once '../bin/start_session.php';
require '../bin/page_view.php';
check_login('admin_username', './login.php');
show_header('SET SUBJECT TEACHER');
if (!$_REQUEST) header('location: ./set_class_teacher.php');
$class = $_POST['class'];
$all_subjects = $_POST['subjects'];
$set_teacher = new Set_Teacher('subject', $class, $all_subjects);//declared in contr.php
$set_teacher->amalg_add_teacher();
?>