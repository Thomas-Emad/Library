<?php
include('db/connect.php');
include("functions/permissions.php");

// Get Word For To Day
$sql = $db->prepare("SELECT * FROM `word_day` WHERE status = '1' LIMIT 1;");
$sql->execute();
$word_day = $sql->fetch(PDO::FETCH_OBJ);

// Get Books
$sql = $db->prepare("SELECT code, name, img, author, visits FROM `books` WHERE famous = '1' LIMIT 9");
$sql->execute();
$books = $sql->fetchAll(PDO::FETCH_OBJ);

// Get All Sections
$sql = $db->prepare("SELECT unit_name FROM `unit`;");
$sql->execute();
$sections = $sql->fetchAll(PDO::FETCH_OBJ);

// Get Count All Books
$sql = $db->prepare("SELECT COUNT(books.id) as count FROM `books`;");
$sql->execute();
$count_books = $sql->fetch(PDO::FETCH_OBJ);

// Get Count All Authors
$sql = $db->prepare("SELECT COUNT(authors.id) as count FROM `authors`;");
$sql->execute();
$count_authors = $sql->fetch(PDO::FETCH_OBJ);

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
  <link rel="stylesheet" href="css/index.css" />
  <title>الصفحة الرائيسية | مكتبة البابا أثناسيوس</title>
</head>

<body>
  <!-- Start Header Code -->
  <?php include("templates/header.php"); ?>
  <!-- Home Search Section -->
  <section class="search_home">
    <div class="container h-100">
      <div class="box">
        <h1>مكتبة البابا أثناسيوس للاطلاع</h1>
        <h2>كنيسة الشهيد العظيم مارمينا والبابا كيرلس السادس</h2>
        <form action="search.php" method='GET' class="box_search">
          <i class="fa-solid fa-magnifying-glass icon_search"></i>
          <input type="text" class="btn_text" name="title" required placeholder="أكتب هنا اسم الكتاب..." />
          <input type="submit" class="btn_search" name="search" value="أبحث" />
        </form>
        <div class="buttons">
          <a href="search.php?order=time&search=أبحث" class="link">أحدث الكتب</a>
          <a href="search.php?order=famous&search=أبحث" class="link">أشهر الكتب</a>
          <a href="search.php?order=vs&search=أبحث" class="link">أكثر بحث</a>
        </div>
      </div>
    </div>
  </section>
  <!-- Information About Site -->
  <section class="info_section">
    <div class="container">
      <div class="box">
        <img src="image/layout/Bookshelf.png" class="img_card" alt="Image Card" />
        <h3 class="title">
          <?php echo $count_books->count; ?> كتاب
        </h3>
        <p>آلاف الكتب المنشورة على مكتبة البابا أثناسيوس للاطلاع</p>
      </div>
      <div class="box logo">
        <img src="image/layout/logo.png" class="img_card" alt="Image Card" />
      </div>
      <div class="box">
        <img src="image/layout/books.png" class="img_card" alt="Image Card" />
        <h3 class="title">
          <?php echo $count_authors->count; ?> مؤلف
        </h3>
        <p>
          تهدف مكتبة البابا أثناسيوس إلى نشر المعرفة والعلم الذي تورثناء الي
          الجميع
        </p>
      </div>
    </div>
  </section>
  <!-- Books -->
  <section class="famous_books">
    <div class="container">
      <div class="content_books">
        <div class="info box">
          <h3 class="title"><i class="fa-solid fa-cross"></i> كلمة اليوم</h3>
          <p class="text">
            <?php if (!empty($word_day))
              echo $word_day->content; ?>
          </p>
          <span class="say">
            <?php if (!empty($word_day))
              echo $word_day->source; ?>
          </span>
        </div>
        <div class="books">
          <?php
          foreach ($books as $book) {
            echo "
              <a href='book.php?code=$book->code' class='box'>
                <img src='image/books/$book->img' class='img' loading='lazy' onerror='this.onerror=null;this.src=`image/layout/book.jpg`;' alt='Background Image Book' />
                <div class='text'>
                  <p class='title m-0'>$book->name</p>
                  <p class='write m-0'>$book->author</p>
                </div>
              </a>
            ";
          }
          ?>

        </div>
      </div>
      <div class="books_sections ">
        <div class="parent_content box">
          <div class="info">
            <h3 class="title">
              <i class="fa-solid fa-book-medical"></i> أقسام الكتب
            </h3>
            <a href="#search" data-bs-toggle="modal"><i class="fa-solid fa-magnifying-glass icon"></i></a>
          </div>
          <div class="parent">
            <?php
            foreach ($sections as $section) {
              echo "
                  <a href='search.php?select=section&page=1&title=$section->unit_name&search=أبحث' class='box'>
                    <span>$section->unit_name</span>
                    <i class='fa-solid fa-book-bookmark'></i>
                  </a>
                ";
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Footer -->
  <?php include("templates/footer.html"); ?>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>