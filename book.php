<?php
include("db/connect.php");
include("functions/permissions.php");

// Get Code Book, And Information Book
$code_book = filter_var($_GET['code'], FILTER_SANITIZE_NUMBER_INT);
$sql = $db->prepare("SELECT * FROM `books` INNER JOIN unit WHERE (code = '$code_book');");
$sql->execute();
$book = $sql->fetch(PDO::FETCH_OBJ);

if (empty($book)) {
  header("Location: 404.php");
  exit();
}

// Transformation String To Array => [ Subjects ]
$subjects = explode('-', $book->subjects);

// Add New Visit
$sql = $db->prepare("UPDATE `books` SET `visits` = visits + 1 WHERE `books`.`code` = $code_book;");
$sql->execute();

// Add Book To Famous Book
if (isset($_POST['add_famous'])) {
  if ($book->famous == 1) {
    $sql = $db->prepare("UPDATE `books` SET `famous` = '0' WHERE `books`.`code` = '$code_book';");
    $sql->execute();
  } elseif ($book->famous == 0) {
    $sql = $db->prepare("UPDATE `books` SET `famous` = '1' WHERE `books`.`code` = '$code_book';");
    $sql->execute();
  }
  header("Refresh:0;");
}

// Get Books Like This
$sql = $db->prepare("SELECT code, img, name, author FROM `books` WHERE (unit_number ='$book->unit_number') AND (shelf_number ='$book->shelf_number') LIMIT 9;");
$sql->execute();
$book_like = $sql->fetchAll(PDO::FETCH_OBJ);

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="<?php echo $book->subjects; ?>" />
  <link rel="shortcut icon" href="image/layout/logo.png" type="image/x-icon" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&display=swap"
    rel="stylesheet" />

  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/all.min.css" />
  <link rel="stylesheet" href="css/swiper-bundle.min.css" />
  <link rel="stylesheet" href="css/main.css" />
  <link rel="stylesheet" href="css/book.css" />
  <title>
    <?php echo $book->name; ?> | مكتبة البابا أثناسيوس
  </title>
</head>

<body>
  <!-- Start Header Code -->
  <?php include("templates/header.php"); ?>
  <!-- Content Book -->
  <section class="book">
    <div class="container">
      <div class="parent">
        <h2 class="title"><i class="fa-solid fa-book-open-reader"></i>
          <?php echo $book->name; ?>
        </h2>
        <div class="content">
          <div class="info">
            <div class="box"><i class="fa-solid fa-bookmark"></i> <b>كود:</b>
              <?php echo $book->code; ?>
            </div>
            <div class="box"><i class="fa-solid fa-bookmark"></i> <b>عدد الاجزاء:</b>
              <?php echo $book->part_number; ?>
            </div>
            <div class="box"><i class="fa-solid fa-bookmark"></i> <b>القسم:</b>
              <?php echo $book->section; ?>
            </div>
            <div class="box"><i class="fa-solid fa-bookmark"></i> <b>السلسة:</b>
              <?php echo $book->series; ?>
            </div>
            <div class="box"><i class="fa-solid fa-bookmark"></i> <b>مؤلف:</b>
              <?php echo $book->author; ?>
            </div>
            <div class="box"><i class="fa-solid fa-bookmark"></i> <b>الناشر:</b>
              <?php echo $book->publisher; ?>
            </div>
            <div class="box"><i class="fa-solid fa-bookmark"></i> <b>عدد الصفحات:</b>
              <?php echo $book->num_page; ?>
            </div>
            <div class="box"><i class="fa-solid fa-bookmark"></i> <b>عدد النسخ:</b>
              <?php echo $book->num_copy; ?>
            </div>
            <div class="box"><i class="fa-solid fa-bookmark"></i> <b>رقم الوحدة:</b>
              <?php echo $book->unit_number; ?>
            </div>
            <div class="box"><i class="fa-solid fa-bookmark"></i> <b>رقم الرف:</b>
              <?php echo $book->shelf_number; ?>
            </div>
            <div class="box"><i class="fa-solid fa-bookmark"></i> <b>ترتيب الكتاب:</b>
              <?php echo $book->position_book_sh; ?>
            </div>
            <?php
            if (show_part('admin')) {
              echo "
                <form method='POST' action='' class='box edit'>
                  <a href='main-book.php?code=$code_book' class='btn btn-outline-info'>تعديل علي الكتاب</a>";
              if ($book->famous == 1) {
                echo "<input type='submit' name='add_famous' value='حذف من المميز' class='btn btn-danger'>";
              } elseif ($book->famous == 0) {
                echo "<input type='submit' name='add_famous' value='اضافة الي مميز' class='btn btn-warning'>";
              }
              echo "</form>";
            }
            ?>
          </div>
          <div class="img"><img src="image/books/<?php echo $book->img; ?>"
              onerror='this.onerror=null;this.src=`image/layout/book.jpg`;' alt="img book"></div>
        </div>
      </div>
      <div class="parent">
        <div class="text">
          <h2 class="title"><i class="fa-solid fa-clipboard-list"></i> مواضيع الكتاب</h2>
          <ul class='list'>
            <?php
            foreach ($subjects as $sub) {
              echo "<li>$sub</li>";
            }
            ?>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <!-- Other Books -->
  <section class="other_book">
    <div class="container">
      <div class="parent">
        <h2 class="title"><i class="fa-solid fa-book-medical"></i> كتب مشابه</h2>
        <div #swiperref="" class="swiper mySwiper">
          <div class="swiper-wrapper" id="swiper-wrapper">
            <?php
            foreach ($book_like as $book) {
              ?>
              <a href="book.php?code=<?php echo $book->code; ?>" class="box swiper-slide">
                <img src="image/books/<?php echo $book->img; ?>"
                  onerror='this.onerror=null;this.src=`image/layout/book.jpg`;' class="img" alt="Background Image Book" />
                <p class="title_box m-0">
                  <?php echo $book->name; ?>
                </p>
                <p class="write m-0">
                  <?php echo $book->author; ?>
                </p>
              </a>
              <?php
            }
            ?>
          </div>
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
        </div>
      </div>
    </div>
  </section>
  <!-- Footer -->
  <?php include("templates/footer.html"); ?>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/swiper-bundle.min.js"></script>
  <script src="js/swiper.js"></script>
</body>

</html>