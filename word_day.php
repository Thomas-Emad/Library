<?php
include('db/connect.php');
include("functions/permissions.php");

// Can This Open Page
permission('owner');

// Get All Post
$sql = $db->prepare("SELECT id FROM `word_day`");
$sql->execute();
$rowCount = $sql->rowCount();

// Split Books For Many Pages
if (!isset($_GET['page'])) {
  $_GET['page'] = 1;
}
$countwordPage = 20;
$countword = ceil($rowCount / $countwordPage);
$numPage = $_GET['page'] . 0;
$formula = "LIMIT $countwordPage OFFSET " . (($numPage * 2) - $countwordPage);

$sql = $db->prepare("SELECT * FROM `word_day` ORDER BY `word_day`.`id` DESC $formula;");
$sql->execute();
$words = $sql->fetchAll(PDO::FETCH_OBJ);

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

// If New Word
if (isset($_POST['add_word'])) {
  $bad_operator = ['<', '>', 'DELETE', 'SELECT', 'DROP', 'UPDATA', 'WHERE'];
  $source = str_replace($bad_operator, '', $_POST['source']);
  $content = str_replace($bad_operator, '', $_POST['content']);
  $random_post = date("yd") . rand(0, 100000);

  if (strlen($source) < 3) {
    $errors[] = 'يجب ان يزيد عدد الاحرف (القائل) عن 3 حروف.-';
  }
  if (strlen($content) < 5) {
    $errors[] = 'يجب ان يزيد عدد الاحرف (الكلمة اليوم) عن 5 حروف.-';
  }
  if (strlen($content) >= 500) {
    $errors[] = 'يجب ان لا يزيد عدد الاحرف (الكلمة اليوم) عن 500 حروف.-';
  }

  if (empty($errors)) {
    $sql = $db->prepare("INSERT INTO `word_day` (`id`, `random_num`, `content`, `source`) 
    VALUES (NULL, '$random_post', '$content', '$source')");
    $sql->execute();
    header("Refresh: 0");
  }
}

// When Delete Word 
if (isset($_POST['delete'])) {
  $random_post = filter_var($_POST['random_post'], FILTER_SANITIZE_NUMBER_INT);
  $sql = $db->prepare("DELETE FROM `word_day` WHERE `word_day`.`random_num` = $random_post;");
  $sql->execute();
  header("Refresh: 0");
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
  <link rel="stylesheet" href="css/word_day.css" />
  <title>كلمة اليوم | مكتبة البابا أثناسيوس</title>
</head>

<body>
  <!-- Start Header Code -->
  <?php include("templates/header.php"); ?>

  <!-- Content -->
  <section class="word_day">
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
    <div class="container">
      <!-- Modal Add New Word -->
      <div class="modal fade" id="add_new_word" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form action="" method="POST">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-envelopes-bulk"></i> أضافة
                  الكلمة جديد</h1>
                <i class="fa-solid fa-xmark close_modal" data-bs-dismiss="modal" aria-label="Close"></i>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label for="source-text" class="col-form-label"><i class="fa-solid fa-user-pen"></i>
                    القائل:</label>
                  <input type="text" class="form-control" name='source' value='<?php if (isset($_POST['source']))
                    echo $_POST['source']; ?>' id="source-text" placeholder='ما هو مصدر هذا العبارة؟'>
                </div>
                <div class="mb-3">
                  <label for="message-text" class="col-form-label"><i class="fa-solid fa-envelope-open-text"></i>
                    الكلمة اليوم:</label>
                  <textarea class="form-control" id="message-text" name="content"
                    placeholder="أكتب هنا محتوي الكلمة اليوم..."><?php if (isset($_POST['content']))
                      echo $_POST['content']; ?></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">الغاء</button>
                <input type="submit" name="add_word" class="btn btn-success" value="أضافه">
              </div>
            </form>
          </div>
        </div>
      </div>
      <h1>كلمة اليوم</h1>
      <div class="add_word box">
        <span class='title'>أضافة كلمة جديد</span>
        <a href="#add_new_word" data-bs-toggle="modal" class="add">أضافة</a>
      </div>
      <hr>
      <div class="parent">
        <?php
        foreach ($words as $word) {
          ?>
          <div class="box">
            <!-- Modal Delete Post -->
            <div class="modal fade" id="delete_post<?php echo $word->random_num ?>" tabindex="-1"
              aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <form action="" method='POST'>
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-trash-can icon_del"></i>
                        حذف هذا
                        الكلمة!!</h1>
                      <i class="fa-solid fa-xmark close_modal" data-bs-dismiss="modal" aria-label="Close"></i>
                    </div>
                    <div class="modal-body">
                      <input type="text" name="random_post" value="<?php echo $word->random_num ?>" hidden>
                      <p>- سيتم حذف هذا الكلمة نهائي, هل انت متاكد؟!</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">الغاء</button>
                      <input type="submit" name="delete" class="btn btn-outline-danger" value='حذف الكلمة'>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="text d-flex gap-2">
              <p>
                <?php echo $word->content ?>
              </p>
              <a href='#delete_post<?php echo $word->random_num ?>' data-bs-toggle='modal' class='icon_del icon'><i
                  class='fa-solid fa-trash-can '></i></a>
            </div>
            <span>
              <?php echo $word->source ?>
            </span>
          </div>
          <?php
        } ?>
      </div>
      <?php
      if (empty($words)) {
        echo "<p class='msg'> قريبا, لا يوجد منشورات الان..</p>";
      }
      ?>
      <div id="pagination">
        <ul class="pagination">
          <?php
          if (isset($words)) {
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
            for ($i = 1; $i <= $countword; $i++) {
              if ($i == $_GET['page']) {
                echo "<li class='page-item'><a class='page-link active' href='" . update_par($i) . "'>$i</a></li>";
              } else {
                echo "<li class='page-item'><a class='page-link' href='" . update_par($i) . "'>$i</a></li>";
              }
            }

            if ($_GET['page'] != $countword && $countword != 0) {
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
  </section>


  <!-- Footer -->
  <?php include("templates/footer.html"); ?>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>