<?php
require_once '../bin/start_session.php';
require_once '../bin/errorlib.php';
require '../bin/page_view.php';
show_header('LOGIN');
handle_session_errors();
?>
<form method="post" action="loginx.php">
	<p>INPUT USERNAME: <input type="text" name="admin_username"></p>
	<p>INPUT PASSWORD: <input type="password" name="admin_password"></p>
	<p><input type="submit" name="admin_login" value="LOGIN"></p>
</form>
<?php show_footer(); ?>