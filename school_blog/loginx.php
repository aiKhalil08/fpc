<?php
require '../bin/page_view.php';
require '../bin/contr.php';
check_request(false, './login.php');
if (!$_REQUEST) header('location: ./login.php');
$login_username = $_POST['writer_username'];
$login_password = $_POST['writer_password'];

if (empty($login_username) || empty($login_password)) {
    $_SESSION['errors'] = ['Please fill all fields.'];
    header('location: ./login.php');
    die();
}

$writers = file('./writers.txt');

$eligible = false;
foreach($writers as $writer) {
    list($username, $type) = explode(',', $writer);
    if (strtolower(trim($username)) == strtolower(trim($login_username))) {
        $eligible = true;
        break;
    }
}

if (!$eligible) {
    $_SESSION['errors'] = ['You are not eligible to write a blog post.'];
    header('location: ./login.php');
    die();
} else {
    $username = trim($username);
    $type = trim($type);
    $info = Database::check_unique_username($username, $type.'s', 1);
    if (strtolower($info[$type.'_last_name']) == trim($login_password)) {
        header('location: ./write_blog.php?t='.base64_encode($type).'&u='.base64_encode($username));
    } else {
        $_SESSION['errors'] = ['You have inputted a wrong password.'];
        header('location: ./login.php');
        die();
    }
}

?>