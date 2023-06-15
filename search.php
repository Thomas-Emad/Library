<?php
include("db/connect.php");
include("functions/permissions.php");

// Check If Paremters Is Exist Or Get Defult Value
if (!isset($_GET['title'])) {
  $_GET['title'] = '';
}
if (!isset($_GET['select'])) {
  $_GET['select'] = 'name';
}
if (!isset($_GET['page'])) {
  $_GET['page'] = 1;
}
if (!isset($_GET['unit'])) {
  $_GET['unit'] = 1;
}

// Checked Input
$title = '';
$type_search = 'name';
function checked_input($input_value)
{
  global $type_search;
  if (isset($type_search) && $type_search == $input_value) {
    echo 'checked';
  }
}

// Search Code
if (isset($_GET['search'])) {
  $str_replace = ['<', '>', 'SELECT', 'DELETE', 'DROP'];
  $unit = str_replace($str_replace, '', $_GET['unit']);
  $title = str_replace($str_replace, '', $_GET['title']);
  $type_search = filter_var($_GET['select'], FILTER_SANITIZE_EMAIL);

  function choose_type($type_search)
  {
    global $title, $unit;
    if ($type_search == 'name') {
      return "name LIKE '%$title%'";
    } elseif ($type_search == 'subjects') {
      return "subjects LIKE '%$title%'";
    } elseif ($type_search == 'shelf_number') {
      return "unit_number = '$unit' AND shelf_number = '$title'";
    } elseif ($type_search == 'section') {
      return "unit_name LIKE '%$title%'";
    } elseif ($type_search == 'author') {
      return "author LIKE '%$title%'";
    } elseif ($type_search == "all") {
      return "((name LIKE '%$title%') OR (subjects LIKE '%$title%') OR (author LIKE '%$title%'))";
    } else {
      return "name LIKE '%$title%'";
    }
  }

  // Order Books By => $order
  function orderBy()
  {
    if (isset($_GET['order'])) {
      if ($_GET['order'] == 'vs') {
        return " ORDER BY `books`.`visits` DESC";
      } elseif ($_GET['order'] == 'time') {
        return " ORDER BY `books`.`add_time` DESC";
      } elseif ($_GET['order'] == 'famous') {
        return " ORDER BY `books`.`famous` DESC ";
      }
    }
  }

  // Get Count Books
  $sql = $db->prepare("SELECT code FROM `books`, `unit` WHERE " . choose_type($type_search) . " AND (unit.unit_name = books.section);");
  $sql->execute();
  $rowCount = $sql->rowCount();

  // Split Books For Many Pages
  $countBookPage = 10;
  $countPage = ceil($rowCount / $countBookPage);
  $numPage = $_GET['page'] . 0;
  $formula = "LIMIT $countBookPage OFFSET " . ($numPage - $countBookPage);

  // Get Books By Number Page
  $sql = $db->prepare("SELECT code, name, img, author FROM `books`, `unit` WHERE " . choose_type($type_search) . " AND (unit.unit_name = books.section) " . orderBy() . "  $formula;");
  $sql->execute();
  $results = $sql->fetchAll(PDO::FETCH_OBJ);

}

// Function For Update parmenter Page
function update_par($upload_page)
{
  global $numPage;
  if ($numPage > $upload_page) {
    $strToArray = explode('&', $_SERVER['REQUEST_URI']);
    $site_page_paremter = array_search('page=' . $_GET['page'], $strToArray);
    if ($site_page_paremter == true) {
      $strToArray[$site_page_paremter] = "page=$upload_page";
    } else {
      $strToArray[] = "page=$upload_page";
    }
    $arrayToStr = implode('&', $strToArray);
    return $arrayToStr;
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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Cairo:wght@300;400;600;800&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/all.min.css" />
  <link rel="stylesheet" href="css/main.css" />
  <link rel="stylesheet" href="css/search.css" />
  <title>الصفحة البحث | مكتبة البابا أثناسيوس</title>
</head>

<body>
  <!-- Start Header Code -->
  <?php include("templates/header.php"); ?>
  <!-- Content -->
  <section class="search_box">
    <div class="search">
      <div class="container">
        <h1>مكتبة البابا أثناسيوس للاطلاع</h1>
        <h2>كنيسة الشهيد العظيم مارمينا والبابا كيرلس السادس</h2>
        <form action="" method="GET" class="form_box">
          <details class="filter">
            <summary><i class="fa-solid fa-sliders"></i></summary>
            <div class="inputs_rad">
              <div class="box">
                <input type="radio" name="select" id="namePost" value="name" <?php checked_input('name') ?>>
                <label for="namePost">اسم الكتاب</label>
              </div>
              <div class="box">
                <input type="radio" name="select" id="subjects" value="subjects" <?php checked_input('subjects') ?>>
                <label for="subjects">الموضوع</label>
              </div>
              <div class="box">
                <input type="radio" name="select" id="section" value="section" <?php checked_input('section') ?>>
                <label for="section">القسم</label>
              </div>
              <div class="box">
                <input type="radio" name="select" id="writer" value="author" <?php checked_input('author') ?>>
                <label for="writer">الموالف</label>
              </div>
            </div>
          </details>
          <div class="box_search">
            <input type="hidden" name="page" value='1'>
            <i class="fa-solid fa-magnifying-glass icon_search"></i>
            <input type="text" class="btn_text" name="title" required value="<?php echo $title; ?>"
              placeholder="أكتب هنا ما تريد..." />
            <input type="submit" name="search" class="btn_search" value="أبحث" />
          </div>
        </form>
      </div>
    </div>
  </section>
  <!-- Result -->
  <section class="result">
    <div class="container">
      <h3 class='m-3'>النتائج:
        <?php echo $title; ?>
      </h3>
      <div class="books">
        <?php
        if (isset($results)) {
          foreach ($results as $book) {
            echo "
              <a href='book.php?code=$book->code' class='box'>
                <img src='image/books/$book->img' class='img' onerror='this.onerror=null;this.src=`image/layout/book.jpg`;'
                  alt='Background Image Book' loading='lazy' />
                <div class='text'>
                  <p class='title m-0'>$book->name</p>
                  <p class='write m-0'>$book->author</p>
                </div>
              </a>
            ";
          }
        }
        ?>
      </div>
      <?php
      if (!isset($results) || sizeof($results) == 0) {
        echo '<p class="msg">لا يوجد هذا الكتاب..</p>';
      }
      ?>
      <div class="pagination">
        <ul class="pagination">
          <?php
          if (isset($results)) {
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
            for ($i = 1; $i <= $countPage; $i++) {
              if ($i == $_GET['page']) {
                echo "<li class='page-item'><a class='page-link active' href='" . update_par($i) . "'>$i</a></li>";
              } else {
                echo "<li class='page-item'><a class='page-link' href='" . update_par($i) . "'>$i</a></li>";
              }
            }

            if ($_GET['page'] != $countPage && $countPage != 0) {
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