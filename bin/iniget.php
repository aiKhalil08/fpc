<?php
echo ini_get('date.timezone');
echo '<noscript>';
header('location: ./login.php');
echo '</noscript>';
?>