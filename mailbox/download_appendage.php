<?php
$id = trim($_GET['id']);
$type = $_GET['type'];
$file = '../bin/mails/appendages/'.$id.'.'.$type;
if ($type == 'png' || $type == 'jpeg' || $type == 'gif') {
	$content_type = 'image/'.$type;
} else if ($type == 'mp3') {
	$content_type = 'audio/'.$type;
} else if ($type == 'mp4' || $type == 'mkv') {
	$content_type = 'video/'.$type;
} else {
	$content_type = 'application/'.$type;
}
header('Content-Type: '.$content_type);
header('Content-Description: File Transfer');
header('Content-Disposition: attachemet; filename = '.$id.'.'.$type);
$content = file_get_contents($file);
echo $content;
?>