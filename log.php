<?php
include("db/connect.php");

if (isset($_COOKIE['username'])) {
  header("location: index.php");
  exit();
}

$url = strtolower($_GET['url']);

if ($url == 'register') {
  $title_site = 'أنشاء حساب';
  $errors = [];
  include('functions/verify_data.php');

  if (isset($_POST['send'])) {
    $username = date("ymd") . rand(0, 1000);
    $bad_operator = ['<', '>', 'DELETE', 'SELECT', 'DROP', 'UPDATA', 'WHERE'];
    $name = str_replace($bad_operator, '', $_POST['name']);
    $date = $_POST['date'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_EMAIL);

    // Vrify Data
    verify_data($name, 3, 'الاسم');
    verify_data($email, 13, 'البريد الالكتروني');
    verify_data($phone, 11, 'رقم الهاتف');
    verify_data($password, 6, 'كلمة السر');

    // Check If Email Exist Or Not
    $sql = $db->prepare("SELECT email FROM `users` WHERE email = '$email';");
    $sql->execute();
    $email_exist = $sql->rowCount();
    if ($email_exist > 0) {
      $errors[] = 'هذا الحساب موجود بالفعل!!';
    }

    if (empty($errors)) {
      $sql = $db->prepare("INSERT INTO `users` (`id`, `username`, `name`, `email`, `phone`, `password`, `img`, `permissions`, `birthday`, `create_at`) VALUES
        (NULL, '$username', '$name', '$email', '$phone', '$password', '', 'user', '$date', current_timestamp());");
      $sql->execute();
      setcookie('username', "$username", time() + 1 * 365 * 24 * 60 * 60, '/');
      header("Location: index.php");
    }
  }

} elseif ($url == 'login') {
  $title_site = 'تسجيل دخول';

  $errors = [];
  function verify_data($var, $count, $msg)
  {
    global $errors;
    if (strlen($var) == 0) {
      $errors[] = "يجب ادخال $msg";
    }
  }

  if (isset($_POST['send'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_EMAIL);

    verify_data($email, 13, 'البريد الالكتروني');
    verify_data($password, 6, 'كلمة السر');

    // Check From Data Is Ture Or False
    if (empty($errors)) {
      $sql = $db->prepare("SELECT username FROM `users` WHERE email = '$email' AND password = '$password';");
      $sql->execute();
      $result = $sql->fetch(PDO::FETCH_OBJ);
      if (!empty($result)) {
        setcookie('username', "$result->username", time() + 1 * 365 * 24 * 60 * 60, '/');
        header("Location:index.php");
      } else {
        $errors[] = 'يوجد خطا في البيانات!!';
      }
    }
  }
} else {
  header('Location: 404.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="صفحة تسجيل دخول, انشاء حساب" />
  <link rel="shortcut icon" href="image/layout/logo.png" type="image/x-icon" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&display=swap"
    rel="stylesheet" />

  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/all.min.css" />
  <link rel="stylesheet" href="css/log.css" />
  <title>
    <?php echo $title_site; ?> | مكتبة البابا أثناسيوس
  </title>
</head>

<body>
  <?php
  if (!empty($errors)) {
    echo "
    <div class='alert alert-warning errors' role='alert'>";
    foreach ($errors as $err) {
      echo "- $err <br>";
    }
    echo "</div>";
  }
  ?>
  <?php
  if ($url == 'register') {
    ?>
    <section class="content">
      <div class="container">
        <form action="" method="POST" class="parent">
          <a href="index.php"><img src="image/layout/logo.png" alt="logo" class="img" /></a>
          <h2 class='title_page'>أنشاء حساب</h2>
          <div class="box mb-3 mt-3">
            <input type="text" name="name" class="form-control" id="name_label" required value="<?php if (isset($name))
              echo $name; ?>" />
            <label for="name_label">الاسم</label>
          </div>
          <div class="box mb-3">
            <input type="email" name="email" class="form-control" id="email_label" required value="<?php if (isset($email))
              echo $email; ?>" />
            <label for="email_label">البريد الالكتروني</label>
          </div>
          <div class="box mb-3">
            <input type="tel" name="phone" class="form-control" id="number_label" required value="<?php if (isset($phone))
              echo $phone; ?>" />
            <label for="number_label">رقم الهاتف</label>
          </div>
          <div class="box mb-3">
            <input type="date" name="date" class="form-control" id="date_label" required />
            <label for="date_label" class='label_top'>تاريخ ميلاك</label>
          </div>
          <div class="box mb-3">
            <input type="password" name="password" class="form-control" id="password_label" />
            <label for="password_label">كلمة السر</label>
            <span id="show"><i class="fa-solid fa-eye-low-vision"></i></span>
          </div>
          <input type="submit" name="send" value="أنشاء حساب" class="btn box p-2" />
          <hr class="box" />
          <p class="text">هل لديك حساب؟ <a href="log.php?url=login">تسجيل دخول</a></p>
        </form>
      </div>
    </section>
    <?php
  } elseif ($url == 'login') {
    ?>
    <section class="content">
      <div class="container">
        <form action="" method="POST" class="parent">
          <a href="index.php"><img src="image/layout/logo.png" alt="logo" class="img" /></a>
          <h2 class='title_page'>تسجيل دخول</h2>
          <div class="box mb-3 mt-3">
            <input type="email" class="form-control" name="email" id="email_label" value="<?php if (isset($email))
              echo $email; ?>" />
            <label for="email_label">البريد الالكتروني</label>
          </div>
          <div class="box mb-3">
            <input type="password" class="form-control" name="password" id="password_label" />
            <label for="password_label">كلمة السر</label>
            <span id="show"><i class="fa-solid fa-eye-low-vision"></i></span>
          </div>
          <input type="submit" name="send" value="تسجيل دخول" class="btn box p-2" />
          <hr class="box" />
          <p class="text">ليس لديك حساب؟ <a href="log.php?url=register">انشاء حساب</a></p>
        </form>
      </div>
    </section>
    <?php
  } ?>
  <script src="js/main.js"></script>
</body>

</html>