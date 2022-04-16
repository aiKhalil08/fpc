<?php
require '../bin/contr.php';
require '../bin/view.php';
require_once '../bin/start_session.php';
require '../bin/page_view.php';
check_login('admin_username', './login.php');
show_header('SET CLASS SUBJECTS');
if (!$_REQUEST) header('location: ./set_class_subjects.php');
$class = $_POST['class'];
$class_subjects = $_POST['class_subjects'];
$set_class_subjects = new Set_Class_Subjects($class, $class_subjects);//declared in contr.php
$set_class_subjects->amalg_add_class_subjects($class_subjects);
?>