<?php
include("functions/permissions.php");

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="robots" content="noindex">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="قد يظهر هذا الخطا نتيجة دخول الي صفحة غير موجود أو غير المسموح لك بدخول اليها" />
  <link rel="shortcut icon" href="image/logo.png" type="image/x-icon" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&display=swap"
    rel="stylesheet" />

  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/all.min.css" />
  <link rel="stylesheet" href="css/swiper-bundle.min.css" />
  <link rel="stylesheet" href="css/main.css" />
  <link rel="stylesheet" href="css/404.css" />
  <title> يوجد خطا هنا!! | مكتبة البابا أثناسيوس</title>
</head>

<body>
  <!-- Header -->
  <?php include("templates/header.php"); ?>

  <div class="container content_page">
    <img src="image/layout/404.jpg" alt="404 image error">
    <b>يوجد خطا هنا!!</b>
    <p>قد يظهر هذا الخطا نتيجة دخول الي صفحة غير موجود أو غير المسموح لك بدخول اليها</p>
  </div>

  <!-- Footer -->
  <?php include("templates/footer.html"); ?>
  <script src="js/bootstrap.bundle.min.js"></script>

</body>

</html>