<?php
function admin_array() {
    return array('Add student' => './addstudent.php', 'Add staff' => './addstaff.php', 'View all students' => './allstudents.php', 'View all staff' => './allstaffs.php','Classes info' => './view_class.php', 'Search student' => './search_student.php', 'Search staff' => './search_staff.php', 'Delete student' => './delete_student.php', 'Delete staff' => './delete_staff.php', 'Promote students'=>'./promote_students.php', 'Set session and term' => './set_session.php', 'Set curriculum' => './set_all_subjects.php', 'View curriculum' => './view_all_subjects.php', 'Results archive' => '../results_archive/index.php', 'Mailbox' => '../mailbox/index.php?pe='.base64_encode('admin').'&me='.base64_encode('admin'), 'Manage blog'=>'../school_blog/manage_blog.php');
}


function mail_array($type, $username) {
    return array('Home'=>'./index.php?pe='.base64_encode($type).'&me='.base64_encode($username), 'Send mail'=>'./send_mail.php?pe='.base64_encode($type).'&me='.base64_encode($username), 'Sent mails'=>'./sent_mails.php?pe='.base64_encode($type).'&me='.base64_encode($username));
}


function staff_array() {
    $staff_sidebar_array = array('Classes'=>'./view_classes.php', 'Take students\' attendance'=>'./take_attendance.php', 'Subjects'=>'./subjects.php', 'View students\' results'=>'./student_results.php', 'Publish results'=>'./publish_results.php', 'Write classteacher\'s comment'=>'./write_classteacher_comments.php');
    if ($_COOKIE['staff_role'] == 'PRINCIPAL') {
        $staff_sidebar_array['Write principal\'s comment'] = './write_principal_comments.php';
    }
    $staff_sidebar_array['Mailbox'] = '../mailbox/index.php?pe='.base64_encode($_COOKIE['user_type']).'&me='.base64_encode($_COOKIE['staff_username']);
    $staff_sidebar_array['School blog'] = '../school_blog/index.php';
    return $staff_sidebar_array;
}

function student_array() {
    $student_sidebar_array = array('My info'=>'./student_bio.php', 'My class'=>'./class_info.php', 'My subjects'=>'./class_subjects.php', 'Check results'=>'./view_result.php', 'Pay school charges'=>'./pay_charges.php', 'Mailbox' => '../mailbox/index.php?pe='.base64_encode($_COOKIE['user_type']).'&me='.base64_encode($_COOKIE['student_username']), 'School blog'=>'../school_blog/index.php');
    return $student_sidebar_array;
}


function blog_array() {
    return array('Home'=>'./manage_blog.php', 'Writers'=>'./writers.php', 'Delete blogs'=>'./delete_posts.php', 'Write blog'=>'./write_blog.php?t='.base64_encode('admin'));
}


function fpcindex_array() {
    return array('Student login'=>'../student/login.php', 'Staff login'=>'../staff/login.php', 'School blog'=>'../school_blog/index.php', 'About school'=>'./about_school.php', 'Contact info'=>'./contact_info.php', 'Developer\'s contact'=>'./developers_contact.php');
}


function check_active(string $present_link, string $page_link) {
    if (preg_match('/^\.\./', $present_link)) {return;}
    $match1 = [];
    $match2 = [];
    preg_match('/^.*\/{1}([^\?]+).*/i', $present_link, $match1);
    preg_match('/^.*\/{1}([^\?]+).*/i', $page_link, $match2);
    if ($match1[1] == $match2[1]) {return 'yes';}
}

function create_sidebar(string $type, $user_type = false, $username = false) : void {
    if ($type == 'admin') {
        $array = admin_array();
        foreach ($array as $key => $value) {
            echo '<li data-active=\''.check_active($value, $_SERVER['PHP_SELF']).'\'><a href=\''.$value.'\'';
            if (preg_match('/mailbox/', $value) || preg_match('/school_blog/', $value) || preg_match('/results_archive/', $value)) echo ' target=\'_blank\'';
            echo ' ><span class=\'big_icons fa-stack fa-3x\'>';
            switch (trim(strtolower($key))) {
                case 'add student':
                    echo '<i class="fa-solid fa-plus fa-2xs" style="position: absolute; top: 28%; left: 27%; font-size: .4em;"></i>
                    <i class="fa-solid fa-book-open-reader"></i>';
                    break;
                case 'add staff':
                    echo '<i class="fa-solid fa-plus fa-2xs" style="position: absolute; top: 28%; left: 20%; font-size: .4em;"></i>
                    <i class="fa-solid fa-chalkboard-user"></i>';
                    break;
                case 'view all students':
                    echo '<i class="fa-solid fa-book-open-reader fa-xs" style="position: absolute; top:35%; left:20%;"></i>
                    
                    <i class="fa-solid fa-book-open-reader fa-xs" style="position: absolute; top:55%; left:50%;"></i>';
                    break;
                case 'view all staff':
                    echo '<i class="fa-solid fa-chalkboard-user fa-xs" style="position: absolute; top:35%; left:12%;"></i>
                    
                    <i class="fa-solid fa-chalkboard-user fa-xs" style="position: absolute; top:55%; left:50%;"></i>';
                    break;
                case 'classes info':
                    echo '<i class="fa-solid fa-chalkboard fa-lg" style="position: absolute; top:45%; left:25%;"></i>
                    <i class="fa-solid fa-info fa-2xs" style="position: absolute; top:40%; left:49%; font-size: .5em"></i>';
                    break;
                case 'search student':
                    echo '<i class="fa-solid fa-magnifying-glass fa-2xs" style="position: absolute; top: 28%; left: 24%; font-size: .4em;"></i>
                    <i class="fa-solid fa-book-open-reader"></i>';
                    break;
                case 'search staff':
                    echo '<i class="fa-solid fa-magnifying-glass fa-2xs" style="position: absolute; top: 25%; left: 19%; font-size: .4em;"></i>
                    <i class="fa-solid fa-chalkboard-user"></i>';
                    break;
                case 'delete student':
                    echo '<i class="fa-solid fa-minus fa-2xs" style="position: absolute; top: 28%; left: 24%; font-size: .4em;"></i>
                    <i class="fa-solid fa-book-open-reader"></i>';
                    break;
                case 'delete staff':
                    echo '<i class="fa-solid fa-minus fa-2xs" style="position: absolute; top: 28%; left: 22%; font-size: .4em;"></i>
                    <i class="fa-solid fa-chalkboard-user"></i>';
                    break;
                case 'promote students':
                    echo '<i class="fa-solid fa-caret-up fa-2xs" style="position: absolute; top: 28%; left: 28%; font-size: .4em;"></i>
                    <i class="fa-solid fa-book-open-reader"></i>';
                    break;        
                case 'set session and term':
                    echo '<i class="fa-solid fa-school" style="position: absolute; top: 20%; left: 24%;"></i>';
                    break; 
                case 'set curriculum':
                    echo '<i class="fa-solid fa-plus fa-2xs" style="position: absolute; top: 25%; left: 23%; font-size: .4em;"></i>
                    <i class="fa-solid fa-rectangle-list fa-sm" style="position: absolute; top:50%; left:35%;"></i>';
                    break;
                case 'view curriculum':
                    echo '<i class="fa-solid fa-magnifying-glass fa-2xs" style="position: absolute; top: 24%; left: 21%; font-size: .4em;"></i>
                    <i class="fa-solid fa-rectangle-list fa-sm" style="position: absolute; top:50%; left:38%;"></i>';
                    break;
                case 'mailbox':
                    echo '<i class="fa-solid fa-envelope" style="position: absolute; top: 20%; left: 35%;"></i>';
                    break; 
                case 'results archive':
                    echo '<i class="fa-solid fa-box-archive" style="position: absolute; top: 20%; left: 33%;"></i>';
                    break; 
                case 'manage blog':
                    echo '<i class="fa-solid fa-blog" style="position: absolute; top: 20%; left: 38%;"></i>';
                    break; 
            }
            echo '</span>'.$key.'</a></li>';
        }
    } else if ($type == 'mailbox') {
        $array = mail_array($user_type, $username);
        foreach ($array as $key => $value) {
            echo '<li data-active=\''.check_active($value, $_SERVER['PHP_SELF']).'\'><a href=\''.$value.'\' ><span class=\'big_icons fa-stack fa-3x\'>';
            switch (trim(strtolower($key))) {
                case 'home':
                    echo '<i class="fa-solid fa-home" style="position: absolute; top: 28%; left: 27%;"></i>';
                    break;
                case 'send mail':
                    echo '<i class="fa-solid fa-paper-plane" style="position: absolute; top: 28%; left: 32%;"></i>';
                    break;
                case 'sent mails':
                    echo '<i class="fa-solid fa-envelopes-bulk" style="position: absolute; top:28%; left:27%;"></i>';
                    break;
            }
            echo '</span>'.$key.'</a></li>';
        }
    } else if ($type == 'staff') {
        $array = staff_array();
        foreach ($array as $key => $value) {
            echo '<li data-active=\''.check_active($value, $_SERVER['PHP_SELF']).'\'><a href=\''.$value.'\'';
            if (preg_match('/mailbox/', $value) || preg_match('/school_blog/', $value)) echo ' target=\'_blank\'';
            echo ' ><span class=\'big_icons fa-stack fa-3x\'>';
            switch (trim(strtolower($key))) {
                case 'classes':
                    echo '<i class="fa-solid fa-chalkboard fa-lg" style="position: absolute; top:45%; left:25%;"></i>
                    <i class="fa-solid fa-info fa-2xs" style="position: absolute; top:40%; left:49%; font-size: .5em"></i>';
                    break;
                case 'take students\' attendance':
                    echo '<i class="fa-solid fa-list" style="position: absolute; top: 28%; left: 32%;"></i>';
                    break;
                case 'subjects':
                    echo '<i class="fa-solid fa-info fa-2xs" style="position: absolute; top: 27%; left: 27%; font-size: .4em;"></i>
                    <i class="fa-solid fa-rectangle-list fa-sm" style="position: absolute; top:50%; left:35%;"></i>';
                    break;
                case 'view students\' results':
                    echo '<i class="fa-solid fa-chalkboard fa-lg" style="position: absolute; top:45%; left:25%;"></i>
                    <i class="fa-solid fa-square-poll-vertical fa-2xs" style="position: absolute; top:40%; left:45%; font-size: .5em"></i>';
                    break;
                case 'publish results':
                    echo '<i class="fa-solid fa-chalkboard fa-lg" style="position: absolute; top:45%; left:25%;"></i>
                    <i class="fa-solid fa-upload fa-2xs" style="position: absolute; top:40%; left:45%; font-size: .5em"></i>';
                    break;
                case 'write classteacher\'s comment':
                    echo '<i class="fa-solid fa-comment fa-lg" style="position: absolute; top:45%; left:30%;"></i>';
                    break;
                case 'write principal\'s comment':
                    echo '<i class="fa-solid fa-comment fa-lg" style="position: absolute; top:45%; left:30%;"></i>';
                    break;
                case 'mailbox':
                    echo '<i class="fa-solid fa-envelope" style="position: absolute; top: 20%; left: 35%;"></i>';
                    break; 
                case 'school blog':
                    echo '<i class="fa-solid fa-blog" style="position: absolute; top: 20%; left: 38%;"></i>';
                    break; 
            }
            echo '</span>'.$key.'</a></li>';
        }
    } else if ($type == 'student') {
        $array = student_array();
        foreach ($array as $key => $value) {
            echo '<li data-active=\''.check_active($value, $_SERVER['PHP_SELF']).'\'><a href=\''.$value.'\'';
            if (preg_match('/mailbox/', $value) || preg_match('/school_blog/', $value)) echo ' target=\'_blank\'';
            echo ' ><span class=\'big_icons fa-stack fa-3x\'>';
            switch (trim(strtolower($key))) {
                case 'my info':
                    echo '<i class="fa-solid fa-user fa-lg" style="position: absolute; top:45%; left:30%;"></i>';
                    break;
                case 'my class':
                    echo '<i class="fa-solid fa-chalkboard fa-lg" style="position: absolute; top:45%; left:25%;"></i>
                    <i class="fa-solid fa-info fa-2xs" style="position: absolute; top:40%; left:49%; font-size: .5em"></i>';
                    break;
                case 'my subjects':
                    echo '<i class="fa-solid fa-info fa-2xs" style="position: absolute; top: 27%; left: 27%; font-size: .4em;"></i>
                    <i class="fa-solid fa-rectangle-list fa-sm" style="position: absolute; top:50%; left:35%;"></i>';
                    break;
                case 'check results':
                    echo '<i class="fa-solid fa-chalkboard fa-lg" style="position: absolute; top:45%; left:25%;"></i>
                    <i class="fa-solid fa-square-poll-vertical fa-2xs" style="position: absolute; top:40%; left:45%; font-size: .5em"></i>';
                    break;
                case 'pay school charges':
                    echo '<i class="fa-solid fa-credit-card fa-lg" style="position: absolute; top:45%; left:25%;"></i>';
                    break;
                case 'mailbox':
                    echo '<i class="fa-solid fa-envelope" style="position: absolute; top: 20%; left: 35%;"></i>';
                    break; 
                case 'school blog':
                    echo '<i class="fa-solid fa-blog" style="position: absolute; top: 20%; left: 38%;"></i>';
                    break; 
            }
            echo '</span>'.$key.'</a></li>';
        }
    } else if ($type == 'blog') {
        $array = blog_array();
        foreach ($array as $key => $value) {
            echo '<li data-active=\'\'><a href=\''.$value.'\'';
            if (preg_match('/write_blog/', $value)) echo ' target=\'_blank\'';
            echo ' >'.$key.'</a></li>';
        }
    } else if ($type == 'fpcindex') {
        $array = fpcindex_array();
        foreach ($array as $key => $value) {
            echo '<li data-active=\'\'><a href=\''.$value.'\'';
            if ($value == '../school_blog/index.php') echo ' target=\'_blank\'';
            echo ' >'.$key.'</a></li>';
        }
    }
}
?>