<?php
header('content-type: image/'.trim($_GET['type']));
$file = trim($_GET['id']).'.'.trim($_GET['type']);
$file = './posts/images/'.$file;
readfile($file);
