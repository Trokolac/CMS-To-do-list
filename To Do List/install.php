<?php

$db=require './db.inc.php';
$conf=require './config.inc.php';

$stmt_createTasksTable = $db->prepare("
    CREATE TABLE IF NOT EXISTS `tasks`(
        `id` int AUTO_INCREMENT PRIMARY KEY,
        `user_id` int,
        `priority` int,
        `task_name` varchar(30),
        `task_description` text,
        `created_at` datetime DEFAULT now(),
        `updated_at` datetime DEFAULT now() ON UPDATE now(),
        `deleted_at` datetime DEFAULT NULL  
    )
");

$stmt_createTasksTable->execute();

$stmt_createUsersTable = $db->prepare("
    CREATE TABLE IF NOT EXISTS `users`(
        `id` int AUTO_INCREMENT PRIMARY KEY,
        `email` varchar(30),
        `name` varchar(30),
        `password` varchar(32),
        `created_at` datetime DEFAULT now(),
        `updated_at` datetime DEFAULT now() ON UPDATE now(),
        `deleted_at` datetime DEFAULT NULL  
    )
");

$stmt_createUsersTable->execute();

$stmt_createCommentsTable = $db->prepare("
  CREATE TABLE IF NOT EXISTS `comments` (
    `id` int AUTO_INCREMENT PRIMARY KEY,
    `user_id` int,
    `body` text,
    `created_at` datetime DEFAULT now(),
    `deleted_at` datetime DEFAULT null
  )
");

$stmt_createCommentsTable->execute(); 


var_dump( $db->errorInfo() );