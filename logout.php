<?php

if (isset($_COOKIE['username'])) {
  unset($_COOKIE['username']);
  setcookie("username", '', -1, '/');
  header("location:index.php");
} else {
  header("location:index.php");
}