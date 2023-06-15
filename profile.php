<?php
include("db/connect.php");
include("functions/verify_data.php");

// Get Data For User 
if (isset($_GET['code'])) {
  $username = filter_var($_GET['code'], FILTER_SANITIZE_NUMBER_INT);
} else {
  $username = filter_var($_COOKIE['username'], FILTER_SANITIZE_NUMBER_INT);
}
$sql = $db->prepare("SELECT name, email, date(birthday) as date, phone, img FROM `users` WHERE username = '$username';");
$sql->execute();
$data_user = $sql->fetch(PDO::FETCH_OBJ);

if (empty($data_user)) {
  header("Location: 404.php");
  exit();
}

$img = $data_user->img;
$name = $data_user->name;
$email = $data_user->email;
$date = $data_user->date;
$phone = $data_user->phone;

if (isset($_POST['send']) && isset($_COOKIE['username'])) {
  $bad_operator = ['<', '>', 'DELETE', 'SELECT', 'DROP', 'UPDATA', 'WHERE'];
  $name = str_replace($bad_operator, '', $_POST['name']);
  $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  $phone = filter_var($_POST['phone'], FILTER_SANITIZE_EMAIL);
  $change_password = '';

  // Vrify Data
  verify_data($name, 3, 'الاسم');
  verify_data($email, 13, 'البريد الالكتروني');
  verify_data($phone, 11, 'رقم الهاتف');
  if (strlen($_POST['password']) > 0) {
    $password = filter_var($_POST['password'], FILTER_SANITIZE_EMAIL);
    verify_data($password, 6, 'كلمة السر');
    $change_password = ', password = ' . $password;
  }

  // Upload Img Profile
  if ($_FILES['img']['error'] != 4) {
    $img_array = $_FILES['img'];
    $type_img_allow = ['png', 'jpg', 'jpeg'];
    $type_img = explode('/', $img_array['type'])[1];
    if (in_array($type_img, $type_img_allow)) {
      @unlink("image/users/$img");
      $img = $username . "." . $type_img;
      move_uploaded_file($img_array['tmp_name'], "image/users/$img");
    } else {
      $errors[] = 'لا يمكنك رفع صورة   بهذا الصيغة';
    }
  }

  // If You Don't Have Any Error Upload Data
  if (empty($errors)) {
    $sql = $db->prepare("UPDATE `users` SET
      name = '$name',
      email = '$email',
      phone = '$phone ' $change_password,
      img = '$img'
      WHERE `users`.`username` = '$username';");
    $sql->execute();
    header("Location: index.php");
  }
}

// For Is This Not Your Account Disabled input
function dis_input()
{
  if (isset($_GET['code'])) {
    echo "disabled";
  }
}

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description"
    content="هدف المكتبة الحفاظ على التعليم و التسليم الأبائي كما قيل في رسالة يهوذا: ' أَنْ تَجْتَهِدُوا لأَجْلِ الإِيمَانِ الْمُسَلَّمِ مَرَّةً لِلْقِدِّيسِينَ. ' (رسالة يهوذا3:1)
  وتصحيح الفكر الأرثوذكسي بكل الاعمار عملا بقول الديسقولية 'إمحوا الذنب بالتعليم.' وكما قال القديس اثناسيوس الرسولي في كتاب رسائل الروح" />
  <link rel="shortcut icon" href="image/layout/logo.png" type="image/x-icon" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&display=swap"
    rel="stylesheet" />

  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/all.min.css" />
  <link rel="stylesheet" href="css/log.css" />
  <title>
    <?php echo $name ?> | مكتبة البابا أثناسيوس
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
  <section class="content">
    <div class="container">
      <form action="" method="POST" class="parent" enctype="multipart/form-data">
        <div class="img_box">
          <label for="img_profile">
            <img src="image/users/<?php echo $img; ?>" alt="logo" class="img"
              onerror='this.onerror=null;this.src=`image/layout/someone.jpg`;' />
          </label>
          <input type="file" name='img' id='img_profile' hidden <?php dis_input(); ?>>
        </div>
        <h2 class='title_page'>الملف الشخصي</h2>
        <div class="box mb-3 mt-3">
          <input type="text" name="name" class="form-control" id="name_label" required value="<?php echo $name; ?>"
            <?php dis_input(); ?> />
          <label for="name_label" class="label">الاسم</label>
        </div>
        <div class="box mb-3">
          <input type="email" name="email" class="form-control" id="email_label" required value="<?php echo $email; ?>"
            <?php dis_input(); ?> />
          <label for="email_label" class="label">البريد الالكتروني</label>
        </div>
        <div class="box mb-3">
          <input type="tel" name="phone" class="form-control" id="number_label" required value="<?php echo $phone; ?>"
            <?php dis_input(); ?> />
          <label for="number_label" class="label">رقم الهاتف</label>
        </div>
        <div class="box">
          <input type="date" name="date" class="form-control" id="date_label" value="<?php echo $date; ?>" disabled />
          <label for="date_label" class='label_top'>تاريخ ميلاك</label>
        </div>
        <?php
        if (!isset($_GET['code'])) {
          ?>
          <div class="box mt-3">
            <input type="password" name="password" class="form-control" id="password_label" <?php dis_input(); ?> />
            <label for="password_label" class="label">تغير كلمة السر</label>
            <span id="show"><i class="fa-solid fa-eye-low-vision"></i></span>
          </div>
          <input type='submit' name='send' value='حفظ التغيرات' class='btn box p-2 mt-3' />
          <?php
        }
        ?>
        <hr class="box" />
        <p class="btn box" style='background-color: #777'><a href="index.php" style='color:#fff;'>الصفحة الرئيسية</a>
        </p>
      </form>
    </div>
  </section>
  <script src="js/profile.js"></script>
</body>

</html>