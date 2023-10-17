<?php
require_once '../bin/contr.php';
require_once '../bin/start_session.php';
require_once '../bin/errorlib.php';
require '../bin/page_view.php';
require '../bin/sidebar_items.php';

$handle = opendir(getcwd());
$years = [];
readdir();
readdir();
while ($file = readdir($handle)) {
    if (!preg_match('/^\d/', $file)) continue;
    $years[] = $file;
}


?> 
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='viewport' content='width=device-width, initial-scale=.5'>
	<link rel="stylesheet" href="../style/style.css">
	<link rel="stylesheet" href="./archive_style.css">
	<title>ARCHIVE</title>
</head>
<body>
    <header>
        <div id='header_div' class='fa-xl'>
            <div id='motto'>If education is exspensive, try ignorance.</div>
        </div>
	</header>
	<main>
        <h3>RESULTS OF GRADUATED OR DELETED STUDENTS WILL BE STORED HERE.</h3>
        <?php
        foreach ($years as $year) {
            echo '<h4>'.str_replace('_', '/', $year).' SESSION</h4>';
            $handle = opendir(getcwd().'/'.$year);
            readdir($handle);
            readdir($handle);
            echo '<table class=\'sessions\'>';
            echo '<thead><tr><th>S/N</th><th>STUDENT\'S NAME</th><th>RESULTS</th></tr></thead>';
            echo '<tbody>';
            $index = 1;
            while ($result = readdir($handle)) {
                echo '<tr>';
                echo '<td>'.$index++.'.</td>';
                $name = preg_split('/_/', $result);
                $name = strtoupper($name[0].' '.$name[1]);
                echo '<td>'.$name.'</td>';
                echo '<td><a href=\'./'.$year.'/'.trim($result).'\' target=\'blank\'>view results</a></td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        }
        ?>

    </main>
    <footer id='archive_footer'>
        <div>
            <span><a href='../school/index.php' target='_blank'>Homepage</a></span>
            <span><a href='../school/index.php' target='_blank'>Follow on Facebook</a></span>
            <span><a href='https://wa.me/+2347062278821/?text=Hello FPC admin, I am directed here from your website. I want to make an enquiry about the school. My name is __' target='_blank'>Chat on Whatsapp</a></span>
        </div>
        <div>
            <span><a href='../school_blog/all_posts.php' target='_blank'>School Blog</a></span>
            <span><a href='../school/about_school.php' target='_blank'>About school</a></span>
            <span id='last_one'></span>
        </div>
        <div id='devs_contact'><a href='../school/developers_contact.php' target='_blank'>Contact Developer</a></div>
        <div id='copyright_info'>&#x00a9; <?=date('Y')?> FOCAL POINT COLLEGE.</div>
    </footer>
</body>
</html>

