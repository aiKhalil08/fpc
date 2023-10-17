<?php
header('content-type: image/jpeg');
$id = $_GET['id'];
$type = $_GET['t'];
$file = '../bin/passports/'.$type.'s/'.$id.'.jpg';
if (is_file($file)) readfile($file);