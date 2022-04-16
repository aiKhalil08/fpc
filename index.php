<?php
require './bin/page_view.php';
show_header('HOMEPAGE');
$sidebar_array = array('STUDENT PORTAL'=>'./student/login.php', 'STAFF PORTAL'=>'./staff/login.php');
create_sidebar($sidebar_array);
show_footer();
?>