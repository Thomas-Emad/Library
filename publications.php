<?php
include('db/connect.php');
include("functions/permissions.php");

// Get All Post
$sql = $db->prepare("SELECT id FROM `publications`;");
$sql->execute();
$rowCount = $sql->rowCount();

// Split Books For Many Pages
if (!isset($_GET['page'])) {
  $_GET['page'] = 1;
}
$countPostPage = 10;
$countPost = ceil($rowCount / $countPostPage);
$numPage = $_GET['page'] . 0;
$formula = "LIMIT $countPostPage OFFSET " . (($numPage) - $countPostPage);

$sql = $db->prepare("SELECT publications.post_random, users.name, users.username, users.img as profile_user, publications.img as img_post, publications.content, publications.time_at, publications.market FROM `publications`, `users` WHERE (users.username = publications.username) ORDER BY (CASE WHEN publications.market = 1 THEN 0 ELSE 1 END), publications.`time_at` DESC $formula;");
$sql->execute();
$posts = $sql->fetchAll(PDO::FETCH_OBJ);

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

// When Add New Post
if (isset($_POST['add_post'])) {
  $username = filter_var($_COOKIE['username'], FILTER_SANITIZE_NUMBER_INT);
  $bad_operator = ['<', '>', 'DELETE', 'SELECT', 'DROP', 'UPDATA', 'WHERE'];
  $content = str_replace($bad_operator, '', $_POST['content']);
  $random_post = date("ymd") . rand(0, 1000);
  $img = '';

  if (strlen($content) < 20) {
    $errors['len_content'] = 'يجب ان يتخطي عدد الاحرف 20 حرف.';
  }

  if (empty($errors)) {
    // Upload Img Profile
    if ($_FILES['img']['error'] != 4) {
      $img_array = $_FILES['img'];
      $type_img_allow = ['png', 'jpg', 'jpeg'];
      $type_img = explode('/', $img_array['type'])[1];
      if (in_array($type_img, $type_img_allow)) {
        @unlink("image/users/$img");
        $img = $random_post . "." . $type_img;
        move_uploaded_file($img_array['tmp_name'], "image/posts/$img");
      } else {
        $errors[] = 'لا يمكنك رفع صورة بهذا الصيغة';
      }
    }

    // Add Data If Don't Have Any Error
    if (empty($errors)) {
      $sql = $db->prepare("INSERT INTO `publications` (`id`, `post_random`, `username`, `img`, `content`, `time_at`, `market`) 
      VALUES (NULL, '$random_post', '$username', '$img', '$content', CURRENT_TIMESTAMP, '0')");
      $sql->execute();
      header("Refresh:0");
    }
  }
}

// If User Admin Delete Post
if (isset($_POST['delete'])) {
  $random_post = filter_var($_POST['random_post'], FILTER_SANITIZE_NUMBER_INT);
  $img_post_del = filter_var($_POST['img_post_del'], FILTER_SANITIZE_URL);
  $sql = $db->prepare("DELETE FROM `publications` WHERE `publications`.`post_random` = $random_post;");
  $sql->execute();
  @unlink("image/posts/$img_post_del");
  header("Refresh:0");
}

// If Wnat Save Post In Top Page
if (isset($_POST['market_post'])) {
  $random_post = filter_var($_POST['post_random'], FILTER_SANITIZE_NUMBER_INT);
  $mar_post = filter_var($_POST['mar_post'], FILTER_SANITIZE_NUMBER_INT);
  if ($mar_post == 1) {
    $sql = $db->prepare("UPDATE `publications` SET `market` = '0' WHERE `publications`.`post_random` = $random_post;");
  } else {
    $sql = $db->prepare("UPDATE `publications` SET `market` = '1' WHERE `publications`.`post_random` = $random_post;");
  }
  $sql->execute();
  header("Refresh:0");
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
  <link rel="stylesheet" href="css/publications.css" />
  <title>الصفحة منشورات | مكتبة البابا أثناسيوس</title>
</head>

<body>
  <!-- Start Header Code -->
  <?php include("templates/header.php"); ?>

  <!-- Posts -->
  <section class="publications">
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
      <h1 class='text-center'>المنشورات</h1>
      <?php
      if (show_part('owner')) {
        ?>
        <!-- Modal Add New Post -->
        <div class="modal fade" id="add_new_post" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-envelopes-bulk"></i> أضافة
                    منشور
                    جديد</h1>
                  <i class="fa-solid fa-xmark close_modal" data-bs-dismiss="modal" aria-label="Close"></i>
                </div>
                <div class="modal-body">
                  <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupFile02">أضافة صورة</label>
                    <input type="file" class="form-control" name='img' id="inputGroupFile02">
                  </div>
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label"><i class="fa-solid fa-envelope-open-text"></i>
                      المحتوي:</label>
                    <textarea class="form-control" id="message-text" name="content"
                      placeholder="أكتب هنا محتوي المنشور..."><?php if (isset($_POST['content']))
                        echo $_POST['content']; ?></textarea>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">الغاء</button>
                  <input type="submit" name="add_post" class="btn btn-success" value="نشر المنشور">
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="add_new_post box">
          <p>أضافة منشور جديد</p>
          <a href="#add_new_post" data-bs-toggle="modal" class="add">أضافه</a>
        </div>
        <?php
      }
      ?>
      <hr>
      <div class="parent">
        <?php
        foreach ($posts as $post) {
          ?>
          <div class="box">
            <?php
            if (show_part('owner')) {
              ?>
              <!-- Modal Delete Post -->
              <div class="modal fade" id="delete_post<?php echo $post->post_random; ?>" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <form action="" method='POST'>
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-trash-can "></i> حذف هذا
                          المنشور!!</h1>
                        <i class="fa-solid fa-xmark close_modal" data-bs-dismiss="modal" aria-label="Close"></i>
                      </div>
                      <div class="modal-body">
                        <input type="text" name="random_post" value="<?php echo $post->post_random; ?>" hidden>
                        <input type="text" name="img_post_del" value="<?php echo $post->img_post; ?>" hidden>
                        <p>- سيتم حذف هذا المنشور نهائي, هل انت متاكد؟!</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">الغاء</button>
                        <input type="submit" name="delete" class="btn btn-outline-danger" value='حذف المنشور'>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <?php
            } ?>
            <div class="head">
              <div class="info">
                <a href="profile.php?code=<?php echo $post->username; ?>"><img
                    src="image/users/<?php echo $post->profile_user; ?>"
                    onerror="this.onerror=null;this.src=`image/layout/someone.jpg`;" class="img"
                    alt="Img Profile Add Post"></a>
                <div class='info_user'>
                  <span class="title">
                    <?php echo $post->name; ?>
                  </span>
                  <div class="date">
                    <?php echo $post->time_at; ?>
                  </div>
                </div>
              </div>
              <form action='' method='POST'>
                <?php
                if (show_part('owner')) {
                  echo "
                    <input type='text' name='post_random' value='$post->post_random' hidden>
                    <input type='text' name='mar_post' value='$post->market' hidden>";
                  if ($post->market == 0) {
                    echo "<label class='icon' for='market$post->post_random'><i class='fa-solid fa-bookmark'></i></label>";
                  } else {
                    echo "<label class='icon' for='market$post->post_random' style='color: green;'><i class='fa-solid fa-bookmark'></i></label>";
                  }
                  echo "<input type='submit' id='market$post->post_random' name='market_post' hidden>";

                  echo "<a href='#delete_post$post->post_random' data-bs-toggle='modal' class='icon_del icon'><i class='fa-solid fa-trash-can '></i></a>";
                }
                ?>
              </form>
            </div>
            <div class="body">
              <?php
              if (!empty($post->img_post)) {
                echo "
                  <div class='img'>
                    <img src='image/posts/$post->img_post' alt='Img Post'>
                  </div>
                ";
              }
              ?>
              <div class="text">
                <pre><?php echo $post->content; ?></pre>
              </div>
            </div>
          </div>
          <?php
        }
        if (empty($posts)) {
          echo "<p class='msg'> قريبا, لا يوجد منشورات الان..</p>";
        }
        ?>
      </div>
      <div id="pagination">
        <ul class="pagination">
          <?php
          if (isset($posts)) {
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
            for ($i = 1; $i <= $countPost; $i++) {
              if ($i == $_GET['page']) {
                echo "<li class='page-item'><a class='page-link active' href='" . update_par($i) . "'>$i</a></li>";
              } else {
                echo "<li class='page-item'><a class='page-link' href='" . update_par($i) . "'>$i</a></li>";
              }
            }

            if ($_GET['page'] != $countPost && $countPost != 0) {
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