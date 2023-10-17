<?php
require ('./classes_roles.php');
$conn = new PDO('mysql:host=localhost;dbname=fpc', 'admin', 'fpcadmin1234');
foreach (CLASSES as $class) {
    if ($conn->query('select * from classes where class_name = '.$conn->quote($class))->fetch(PDO::FETCH_ASSOC)) continue;
    if ($conn->query('insert into classes set class_name = '.$conn->quote($class))) {
        echo $class.' has been added to db<br>';
    } else {echo 'something went wrong';}
}
?>