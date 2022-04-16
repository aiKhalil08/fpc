<?php
require '../bin/page_view.php';
require '../bin/start_session.php';
require '../bin/errorlib.php';
show_header('LOGIN');
handle_session_errors();
?>
<form method="post" action="./loginx.php">
	<p>INPUT USERNAME: <input type="text" name="staff_username"></p>
	<p>INPUT PASSWORD: <input type="password" name="staff_password"></p>
	<p><input type="submit" name="staff_login" value="LOGIN"></p>
</form>
<?php
show_footer();
?>