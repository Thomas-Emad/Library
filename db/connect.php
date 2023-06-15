<?php

$dsn = "mysql:host=localhost;dbname=ag-book";
$user = 'root';
$pass = '';

$options = [
  PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
];

try {
  $db = new PDO($dsn, $user, $pass, $options);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo 'Failed To Connect:' . $e;
}