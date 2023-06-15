<?php

function permission($max_per)
{
  global $db;
  $username = filter_var($_COOKIE['username'], FILTER_SANITIZE_NUMBER_INT);
  $sql = $db->prepare("SELECT permissions FROM `users` WHERE username = '$username';");
  $sql->execute();
  $permission = $sql->fetch(PDO::FETCH_OBJ)->permissions;
  if ($permission == 'owner') {
    // login To Every Thing
  } elseif ($permission == $max_per || $permission == 'owner') {
    // Login To Some Pages
  } else {
    header("Location: 403.php");
    exit();
  }
}

function show_part($max_per)
{
  global $db;
  if (isset($_COOKIE['username'])) {
    $username = filter_var($_COOKIE['username'], FILTER_SANITIZE_NUMBER_INT);
    $sql = $db->prepare("SELECT permissions FROM `users` WHERE username = '$username';");
    $sql->execute();
    $permission = $sql->fetch(PDO::FETCH_OBJ)->permissions;
    if ($permission == 'owner') {
      return True;
    } elseif ($permission == $max_per || $permission == 'owner') {
      return True;
    }
  }
}