<?php

$errors = [];
function verify_data($var, $count, $msg, $name = '')
{
  global $errors;
  if (strlen($var) == 0) {
    $errors[$name] = "يجب ادخال $msg";
  } elseif (strlen($var) < $count) {
    $errors[$name] = "يجب ان يكون $msg أكبر من $count.";
  }
}