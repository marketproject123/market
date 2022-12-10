<?php

include_once 'connect.php';

$id = $_GET['id'];

if ($_GET['ac'] == 'edit') {

    $v1 = $_GET['v1'];
    $v2 = $_GET['v2'];
    $v3 = $_GET['v3'];
    $v4 = $_GET['v4'];
    $v5 = $_GET['v5'];

    $db->exec("UPDATE `products` SET `name` = '$v1' WHERE `products`.`id` = $id");
    $db->exec("UPDATE `products` SET `price` = '$v2' WHERE `products`.`id` = $id");
    $db->exec("UPDATE `products` SET `disc` = '$v3' WHERE `products`.`id` = $id");
    $db->exec("UPDATE `products` SET `type` = '$v4' WHERE `products`.`id` = $id");
    $db->exec("UPDATE `products` SET `count` = '$v5' WHERE `products`.`id` = $id");

    echo "OK";
} elseif ($_GET['ac'] == 'rate') {
    $r = $_GET['stars'];
    echo $id;
    $d = $db->query("SELECT * FROM `products` WHERE `products`.`id` = $id")->fetchall()[0]['info'];
    $v = $r.";".$d;
    // echo $v;
    $db->exec("UPDATE `products` SET `info` = '$v' WHERE `products`.`id` = $id");

    echo "OK";
} elseif ($_GET['ac'] == 'order') {
    $v = $_GET['v'];
    
    $db->exec("UPDATE `pyments` SET `status` = '$v' WHERE `pyments`.`id` = $id");
    echo "OK";
} elseif ($_GET['ac'] == 'delet') {
    $t = $_GET["t"];
    echo $_GET["t"];
    $db->exec("DELETE FROM `$t` WHERE `id` = $id;");
    echo "تم المسح";
}
