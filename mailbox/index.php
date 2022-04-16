<?php
require_once '../bin/start_session.php';
require_once '../bin/contr.php';
require_once '../bin/errorlib.php';
require '../bin/page_view.php';
if (!$_REQUEST) header('../index.php');
$type = $_GET['pe'];
$username = $_GET['me'];
$user_type = new Get_User($type, $username);//declared in contr.php
$type = $user_type->get_userf()['type'];
$username = $user_type->get_userf()['username'];
show_header('MAILBOX');
$new_mails = new View_Mails($type, $username);//declared in contr.php
$new = $new_mails->new_mails();
?>
<h1>HI <?= strtoupper($username) ?>, WELCOME TO MAIL BOX</h1>
<?php
$sidebar_array  = array('SEND MAIL.'=>'./send_mail.php?pe='.base64_encode($type).'&me='.base64_encode($username), 'SENT MAILS.'=>'./sent_mails.php?pe='.base64_encode($type).'&me='.base64_encode($username), 'RECEIVED MAILS('.$new.').'=>'./received_mails.php?pe='.base64_encode($type).'&me='.base64_encode($username));
create_sidebar($sidebar_array);
show_footer();
?>
