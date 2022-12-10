<?php

// header('Access-Control-Allow-Origin: *');
// header('Content-Type: application/json');

$db = "";

$host = "localhost";
$user = "root";
$pass = "";

try {
    // خيار تعريف اللغة
    $option = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    );

    // اتصال بقاعدة بيانات
    $db = new PDO("mysql:$host", "$user", "$pass", $option);


    // اظهار اخطاء ماي اسكو ال
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // انشاء قاعدة البيانات اذا كان غير موجود
    $db->query("CREATE DATABASE if NOT EXISTS `marketdb`");
    $db->query("USE `marketdb`");


    
    $db->exec("CREATE TABLE IF NOT EXISTS `admin` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(30) NOT NULL,
            `username` varchar(30) NOT NULL,
            `password` varchar(30) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;      
    
        CREATE TABLE IF NOT EXISTS `products` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(30) NOT NULL,
            `image` varchar(30) NOT NULL,
            `price` int(11) NOT NULL,
            `count` int(11) NOT NULL,
            `type` varchar(30) NOT NULL,
            `disc` varchar(300) NOT NULL,
            `info` varchar(300) NOT NULL,
            `date` timestamp NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

        CREATE TABLE IF NOT EXISTS `pyments` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(30) NOT NULL,
            `phone` int(11) NOT NULL,
            `address` varchar(30) NOT NULL,
            `receipt` varchar(30) NOT NULL,
            `date` timestamp NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
        
        CREATE TABLE IF NOT EXISTS `comments` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(30) NOT NULL,
            `comment` text NOT NULL,
            `info` varchar(30) NOT NULL,
            `date` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
        
        CREATE TABLE IF NOT EXISTS `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(20) NOT NULL,
            `phone` varchar(20) NOT NULL,
            `address` varchar(20) NOT NULL,
            `username` varchar(20) NOT NULL,
            `password` varchar(20) NOT NULL,
            `date` timestamp NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4");



    $admins = $db->query("SELECT * FROM `admin`")->fetchall();
    if (count($admins) == 0) {
        $db->exec("INSERT INTO `admin` (`id`, `name`, `username`, `password`) VALUES (NULL, 'محمد احمد', 'admin1', '123')");
    }

    $items = $db->query("SELECT * FROM `products`")->fetchall();
    if (count($items) == 0) {
        $db->exec("INSERT INTO `products` (`id`, `name`, `image`, `price`, `count`, `type`, `disc`, `info`, `date`) VALUES (NULL, 'شاشة LG', 'tv.jpg', '5000', '30', 'شاشة', 'شاشة LG اصلية \r\n21 بوصة\r\nضمان خمسة سنوات\r\nمتعدد المداخل\r\nالوان HD', '', current_timestamp())");
    }
} catch (Throwable $e) {
    throw $e;
}
