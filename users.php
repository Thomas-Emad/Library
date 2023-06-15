<?php
include('db/connect.php');
include("functions/permissions.php");

// Can This Open Page
permission('owner');

// Check Select Box
function select_input($select_input)
{
  if (isset($_GET['select']) && $_GET['select'] == $select_input) {
    echo 'checked';
  }
}

// Get Count Users
// If You Search By Name, Get All Users By Limit Page
if (isset($_GET['send'])) {
  $str_replace = ['<', '>', 'SELECT', 'DELETE', 'DROP'];
  $name = str_replace($str_replace, '', $_GET['name']);
} else {
  $name = '';
}
function select_order()
{
  if (isset($_GET['select'])) {
    if (isset($_GET['select']) && $_GET['select'] == 'all') {
      return "";
    } else {
      return " AND permissions = '" . $_GET['select'] . "'";
    }
  }
}
$sql = $db->prepare("SELECT username FROM `users` WHERE name LIKE '%$name%'" . select_order());
$sql->execute();
$rowCount = $sql->rowCount();

// Split Books For Many Pages
if (!isset($_GET['page'])) {
  $_GET['page'] = 1;
}
$countAccouuntPage = 20;
$countAccount = ceil($rowCount / $countAccouuntPage);
$numPage = $_GET['page'] . 0;
$formula = "LIMIT $countAccouuntPage OFFSET " . (($numPage * 2) - $countAccouuntPage);

$sql = $db->prepare("SELECT username, name, img, permissions FROM `users` WHERE name LIKE '%$name%' " . select_order() . " $formula;");
$sql->execute();
$users = $sql->fetchAll(PDO::FETCH_OBJ);

// Function For Update parmenter Page
function update_par($upload_page)
{
  global $numPage;
  if ($numPage > $upload_page) {
    $strToArray = explode('?', $_SERVER['REQUEST_URI']);
    $site_page_paremter = array_search('page=' . $_GET['page'], $strToArray);
    if ($site_page_paremter == true) {
      $strToArray[$site_page_paremter] = "page=$upload_page";
    } else {
      $strToArray[] = "page=$upload_page";
    }
    $arrayToStr = implode('?', $strToArray);
    return $arrayToStr;
  }
}

// Change permissions For User
if (isset($_POST['change'])) {
  $username = filter_var($_POST['username'], FILTER_SANITIZE_NUMBER_INT);
  $permission = $_POST['permissions'];

  $sql = $db->prepare("UPDATE `users` SET `permissions` = '$permission' WHERE `users`.`username` = $username;");
  $sql->execute();
  header("Refresh: 0;");
}

// Delete User
if (isset($_POST['delete'])) {
  $username = filter_var($_POST['username'], FILTER_SANITIZE_NUMBER_INT);
  $img_user = filter_var($_POST['img_user'], FILTER_SANITIZE_EMAIL);
  @unlink("image/users/$img_user");

  $sql = $db->prepare("DELETE FROM users WHERE `users`.`username` = $username");
  $sql->execute();
  header("Refresh: 0;");
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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Cairo:wght@300;400;600;800&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/all.min.css" />
  <link rel="stylesheet" href="css/main.css" />
  <link rel="stylesheet" href="css/users.css" />
  <title> الملف الشخصي | مكتبة البابا أثناسيوس</title>
</head>

<body>
  <!-- Start Header Code -->
  <?php include("templates/header.php"); ?>

  <!-- Users -->
  <div class="users">
    <div class="container">
      <form action="" method="GET" class="search" autoComplete="off">
        <div class="box box_shadow">
          <i class="fa-solid fa-user-tie icon"></i>
          <input type="text" name="name" placeholder="اسم المستخدم.." value='<?php if (isset($_GET['name']))
            echo $_GET['name']; ?>' autoComplete="off">
          <input type="submit" name="send" value="بحث">
        </div>
        <div class="box box_shadow">
          <details class="filter">
            <summary><i class="fa-solid fa-sliders"></i></summary>
            <div class="inputs_rad">
              <div class="box_select">
                <input type="radio" name="select" id="all" value="all" checked <?php select_input('all'); ?>>
                <label for="all">الجميع</label>
              </div>
              <div class="box_select">
                <input type="radio" name="select" id="owner" value="owner" <?php select_input('owner'); ?>>
                <label for="owner">الأمين</label>
              </div>
              <div class="box_select">
                <input type="radio" name="select" id="admin" value="admin" <?php select_input('admin'); ?>>
                <label for="admin">الخدام</label>
              </div>
              <div class="box_select">
                <input type="radio" name="select" id="users" value="user" <?php select_input('user'); ?>>
                <label for="users">المستخدمين</label>
              </div>
            </div>
          </details>
        </div>
      </form>
      <hr>
      <div class="result">
        <h3 class='mb-3'>المستخدمين:</h3>
        <div class="parent">
          <?php
          foreach ($users as $user) {
            ?>
            <div class="box box_shadow">
              <a href="profile.php?code=<?php echo $user->username ?>"><img src="image/users/<?php echo $user->img ?>"
                  loading="lazy" onerror="this.onerror=null;this.src=`image/layout/someone.jpg`;" alt="img profile"></a>
              <div class="text">
                <p class="title">
                  <span>
                    <?php echo $user->name; ?>
                  </span>
                  <span class='permissions'>
                    <?php
                    if ($user->permissions == 'owner' || $user->permissions == 'admin') {
                      if ($user->permissions == 'owner') {
                        echo "(الأمين)";
                      } elseif ($user->permissions == 'admin') {
                        echo "(خادم)";
                      }
                    }
                    ?>
                  </span>
                </p>
                <a class="icon" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $user->username ?>">
                  <i class="fa-solid fa-ellipsis-vertical"></i>
                </a>
                <div class="collapse collapse-horizontal list box_shadow" id="collapse<?php echo $user->username ?>">
                  <ul>
                    <li><a href="profile.php?code=<?php echo $user->username ?>" target="_blank">الملف الشخصي</a></li>
                    <li data-bs-toggle="modal" data-bs-target="#per<?php echo $user->username ?>">تغير الاذونات</li>
                    <li data-bs-toggle="modal" data-bs-target="#del<?php echo $user->username ?>">حذف</li>
                  </ul>
                </div>
              </div>
              <!-- Modal Change Permissions -->
              <div class="modal fade" id="per<?php echo $user->username ?>" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <form action="" method="POST" class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">
                        <i class="fa-solid fa-users"></i> هل تريد تغير اذن هذا المستخدم؟
                      </h1>
                      <button type="button" class="close_modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                      </button>
                    </div>
                    <div class="modal-body mt-3 mb-3">
                      <input type="text" name="username" value='<?php echo $user->username; ?>' hidden>
                      <select class="form-select" name="permissions">
                        <option selected>اختار نوع الاذونات الخاصه به</option>
                        <option value="owner">امين</option>
                        <option value="admin">خادم</option>
                        <option value="user">مستخدم</option>
                      </select>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">الغاء</button>
                      <input type="submit" name="change" class="btn btn-primary" value='تغير الاذن'>
                    </div>
                  </div>
                </form>
              </div>

              <!-- Modal Delete User -->
              <div class="modal fade" id="del<?php echo $user->username ?>" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <form action="" method="POST" class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">
                        <i class="fa-solid fa-users"></i> هل تريد حذف هذا المستخدم (
                        <?php echo $user->name ?>)
                      </h1>
                      <button type="button" class="close_modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                      </button>
                    </div>
                    <div class="modal-body">
                      <input type="text" name="username" value='<?php echo $user->username; ?>' hidden>
                      <input type="text" name="img_user" value='<?php echo $user->img; ?>' hidden>
                      <p>- سيتم حذف جميع بيانات المستخدم, من بينهم صورة المستخدم.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">الغاء</button>
                      <input type="submit" name="delete" class="btn btn-danger" value='حذف حساب'>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <?php
          }
          ?>
        </div>
      </div>
      <?php
      if (empty($users)) {
        echo '<p class="msg">لا يوجد مستخدمين</p>';
      }
      ?>
      <div id="pagination">
        <ul class="pagination">
          <?php
          if (isset($users)) {
            if ($_GET['page'] != 1) {
              echo "
                <li class='page-item'>
                  <a class='page-link' href='" . update_par($_GET['page'] - 1) . "' aria-label='Previous'>
                    <span aria-hidden='true'>&laquo;</span>
                  </a>
                </li>
              ";
            }

            // Print Count Page
            for ($i = 1; $i <= $countAccount; $i++) {
              if ($i == $_GET['page']) {
                echo "<li class='page-item'><a class='page-link active' href='" . update_par($i) . "'>$i</a></li>";
              } else {
                echo "<li class='page-item'><a class='page-link' href='" . update_par($i) . "'>$i</a></li>";
              }
            }

            if ($_GET['page'] != $countAccount && $countAccount != 0) {
              echo "
                <li class='page-item'>
                  <a class='page-link' href='" . update_par($_GET['page'] + 1) . "' aria-label='Next'>
                    <span aria-hidden='true'>&raquo;</span>
                  </a>
                </li>
              ";
            }
          }
          ?>
        </ul>
      </div>
    </div>
  </div>
  <!-- Footer -->
  <?php include("templates/footer.html"); ?>
  <script src=" js/bootstrap.bundle.min.js"></script>
</body>

</html>