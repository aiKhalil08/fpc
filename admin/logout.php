<?php
foreach ($_COOKIE as $key => $value) {
    setcookie($key, '', time() -3600);
}
header('location: ./login.php');
?>