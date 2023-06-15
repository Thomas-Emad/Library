<?php
include("db/connect.php");

// Include Functions
include("functions/permissions.php");
include("functions/verify_data.php");

// Only Can This Open This Page.
permission('admin');

// Get Select Inputs Values
$sql = $db->prepare("SELECT unit_name FROM `unit`;");
$sql->execute();
$sections_value = $sql->fetchAll(PDO::FETCH_OBJ);

$sql = $db->prepare("SELECT author FROM `authors`;");
$sql->execute();
$authors_value = $sql->fetchAll(PDO::FETCH_OBJ);

$sql = $db->prepare("SELECT publisher FROM `publishers`;");
$sql->execute();
$publishers_value = $sql->fetchAll(PDO::FETCH_OBJ);

// Print Class Bad For Error Input
function class_error($name)
{
  global $errors;
  if (isset($errors["$name"])) {
    echo "bad_input";
  }
}

// If You Want Edit Book.
if (isset($_GET['code'])) {
  $code_url = filter_var($_GET['code'], FILTER_SANITIZE_NUMBER_INT);
  $sql = $db->prepare("SELECT * FROM `books` WHERE code = '$code_url';");
  $sql->execute();
  $data_book = $sql->fetch(PDO::FETCH_OBJ);
  if (!empty($data_book)) {
    $name = $data_book->name;
    $series = $data_book->series;
    $author = $data_book->author;
    $subjects = $data_book->subjects;
    $section = $data_book->section;
    $publisher = $data_book->publisher;
    $nums_page = $data_book->num_page;
    $code = $data_book->code;
    $nums_copy = $data_book->num_copy;
    $part_number = $data_book->part_number;
    $unit = $data_book->unit_number;
    $shelf = $data_book->shelf_number;
    $num_position = $data_book->position_book_sh;
    $img = $data_book->img;
  } else {
    header("Location: 404.php");
    exit();
  }
}

// If User Want Send Data
if (isset($_POST['send'])) {
  $bad_operator = ['<', '>', 'DELETE', 'SELECT', 'DROP', 'UPDATA', 'WHERE'];
  $name = str_replace($bad_operator, '', $_POST['name']);
  $series = str_replace($bad_operator, '', $_POST['series']);
  $author = str_replace($bad_operator, '', $_POST['author']);
  $subjects = str_replace($bad_operator, '', $_POST['subjects']);
  $section = str_replace($bad_operator, '', $_POST['section']);
  $publisher = str_replace($bad_operator, '', $_POST['publisher']);
  $nums_page = filter_var($_POST['nums_page'], FILTER_SANITIZE_NUMBER_INT);
  $code = filter_var($_POST['code'], FILTER_SANITIZE_NUMBER_INT);
  $nums_copy = filter_var($_POST['nums_copy'], FILTER_SANITIZE_NUMBER_INT);
  $part_number = str_replace($bad_operator, '', $_POST['part_number']);
  $unit = filter_var($_POST['unit'], FILTER_SANITIZE_NUMBER_INT);
  $shelf = filter_var($_POST['shelf'], FILTER_SANITIZE_NUMBER_INT);
  $num_position = filter_var($_POST['num_position'], FILTER_SANITIZE_NUMBER_INT);
  if (!isset($_GET['code'])) {
    $img = '';
  }

  // Verify Data And Message Error And Class.
  $errors = [];
  verify_data($name, 5, 'أسم الكتاب', 'name');
  verify_data($series, 5, 'أسم السلسلة', 'series');
  verify_data($author, 5, 'أسم المؤالف', 'author');
  verify_data($subjects, 5, 'الموضوعات', 'subjects');
  verify_data($section, 5, 'أسم القسم', 'section');
  verify_data($publisher, 5, 'أسم الناشر', 'publisher');
  verify_data($nums_page, 0, 'عدد الصفحات', 'nums_page');
  verify_data($code, 0, 'الكود الخاص بالكتاب', 'code');
  verify_data($nums_copy, 0, 'عدد النسخ لديك', 'nums_copy');
  verify_data($unit, 0, 'رقم الوحدة', 'unit');
  verify_data($shelf, 0, 'رقم الرف', 'shelf');
  verify_data($num_position, 0, 'رقم الكتاب في الرف', 'num_position');

  // If You Don't Have Any Error Add This Book
  if (empty($errors)) {
    // Check From Name Is Exist
    if (!isset($_GET['code'])) {
      $sql = $db->prepare("SELECT name FROM `books` WHERE name = '$name';");
      $sql->execute();
      $name_exist = $sql->rowCount();
      if ($name_exist > 0) {
        $errors['name_exist'] = 'هذا الاسم موجود بالفعل';
      }

      // Check From Code Is Exist
      $sql = $db->prepare("SELECT true FROM `books` WHERE code = '$code';");
      $sql->execute();
      $code_exist = $sql->rowCount();
      if ($code_exist > 0) {
        $errors['code_exist'] = 'هذا الكود موجود بالفعل';
      }
    }

    // Insert New Row For DataBase
    function add_row($value, $searchValues, $dbName, $rowName)
    {
      global $db, $unit;
      $status = false;
      for ($i = 0; $i < sizeof($searchValues); $i++) {
        if ($searchValues[$i]->$rowName == $value) {
          $status = true;
        }
      }
      if ($status == false) {
        $sql = $db->prepare("INSERT INTO `$dbName` (`id`, `num`, `$rowName`) VALUES (NULL, '$unit', '$value')");
        $sql->execute();
      }
    }
    add_row($author, $authors_value, 'authors', 'author');
    add_row($section, $sections_value, 'unit', 'unit_name');
    add_row($publisher, $publishers_value, 'publishers', 'publisher');

    // Upload Img file
    if (empty($errors)) {
      if ($_FILES['img_book']['error'] != 4) {
        $type_img_allow = ['png', 'jpg', 'jpeg'];
        $img_array = $_FILES['img_book'];
        $type_img = explode('/', $img_array['type'])[1];
        if (in_array($type_img, $type_img_allow)) {
          if (isset($_GET['code'])) {
            @unlink("image/books/$img");
          }
          $img = $code . "." . $type_img;
          move_uploaded_file($img_array['tmp_name'], "image/books/$img");
        } else {
          $errors['img_type'] = 'غير مسموح باضافة صورة بهذا الضيغة';
        }
      }
    }

    if (empty($errors)) {
      if (isset($_GET['code'])) {
        // Edit Last Book
        $sql = $db->prepare("UPDATE `books` SET
          `code` = '$code',
          `name` = '$name',
          `part_number` = '$part_number',
          `section` = '$section',
          `series` = '$series',
          `author` = '$author',
          `publisher` = '$publisher',
          `num_page` = '$nums_page',
          `num_copy` = '$nums_copy',
          `unit_number` = '$unit',
          `shelf_number` = '$shelf',
          `position_book_sh` = '$num_position',
          `subjects` = '$subjects',
          `img` = '$img' WHERE `books`.`code` = '$code_url';");
        $sql->execute();
        header("Location: book.php?code=$code");
      } else {
        // Add New Book
        $sql = $db->prepare("INSERT INTO `books` (`id`, `code`, `name`, `img`, `part_number`, `section`, `series`, `author`, `publisher`, `num_page`, `num_copy`, `unit_number`, `shelf_number`, `position_book_sh`, `subjects`, `visits`, `add_time`, `famous`) 
          VALUES (NULL, '$code', '$name', '$img', '$part_number', '$section', '$series', '$author', '$publisher', '$nums_page', '$nums_copy', '$unit', '$unit.$shelf', '$num_position', '$subjects', '0', CURRENT_TIMESTAMP(), '0')");
        $sql->execute();
        header("Location: book.php?code=$code");
      }
    }
  }
}

// Delete Book
if (isset($_POST['delete_book'])) {
  $sql = $db->prepare("DELETE FROM `books` WHERE `books`.`code` = $code_url");
  $sql->execute();

  @unlink("image/books/$img");
  header('Location: index.php');
}



?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="AnyThing Here" />
  <link rel="shortcut icon" href="image/layout/logo.png" type="image/x-icon" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Cairo:wght@300;400;600;800&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/all.min.css" />
  <link rel="stylesheet" href="css/main.css" />
  <link rel="stylesheet" href="css/main-book.css" />
  <title>الصفحة الكتب | مكتبة البابا أثناسيوس</title>
</head>

<body>
  <!-- Start Header Code -->
  <?php include("templates/header.php"); ?>

  <!-- Section Add OR Edit Book -->
  <section class="content_main_book">
    <div class="container">
      <!-- Modal -->
      <?php
      if (isset($_GET['code'])) {
        ?>
        <div class="modal fade" id="delete_book" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" style="top: 70px">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">
                  <i class="fa-solid fa-book-skull"></i>
                  هل تريد حذف هذا الكتاب؟
                </h1>
                <button type="button" class="close_modal" data-bs-dismiss="modal" aria-label="Close">
                  <i class="fa-solid fa-xmark"></i>
                </button>
              </div>
              <div class="modal-body">
                <p class='fs-6'>
                  - اذا تم حذف هذا الكتاب لا يمكنك استرجاع فيما بعد.
                  <br>
                  - سيتم حذف جميع المعلومات الخاص به, بما في ذلك الصورة.
                </p>
              </div>
              <form action="" method="POST" class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">الغاء</button>
                <input type="submit" name='delete_book' value="حذف الكتاب" class="btn btn-outline-danger">
              </form>
            </div>
          </div>
        </div>
        <?php
      }
      ?>
      <form action="" method="POST" class='parent' enctype="multipart/form-data">
        <div class="section">
          <input type="file" name="img_book" id="inputImg" hidden>
          <label class="img" for='inputImg'>
            <b class="fs-1">+</b>
            <span>اضغط لتحديد الصورة</span>
          </label>
          <?php
          if (isset($errors['img_type'])) {
            echo "<p class='error'>- $errors[img_type]</p>";
          }
          if (isset($_GET['code'])) {
            echo "<a href='#delete_book' data-bs-toggle='modal' class='btn btn-outline-danger w-100 mt-3'>حذف الكتاب</a>";
          }
          ?>
        </div>
        <div class="section">
          <div class="box mb-4">
            <div class="input_box">
              <label for="inputName" class="form-label title">الاسم</label>
              <input type="text" name="name" class="form-control input <?php class_error('name') ?>" id="inputName"
                placeholder="أكتب هنا اسم الكتاب.." title="أكتب هنا اسم الكتاب.." value="<?php
                if (isset($_POST["name"])) {
                  echo $_POST['name'];
                } elseif (isset($name)) {
                  echo $name;
                }
                ?>">
            </div>
            <?php
            if (isset($errors['name'])) {
              echo "<p class='error'>- $errors[name]</p>";
            } elseif (isset($errors['name_exist'])) {
              echo "<p class='error'>- $errors[name_exist]</p>";
            } ?>
          </div>
          <div class="box mb-4">
            <div class="input_box">
              <label for="inputSeries" class="form-label title">السلسلة</label>
              <input type="text" name="series" class="form-control input <?php class_error('series') ?>"
                id="inputSeries" placeholder="أكتب هنا اسم السلسلة.." title="أكتب هنا اسم السلسلة.." value="<?php
                if (isset($_POST["series"])) {
                  echo $_POST['series'];
                } elseif (isset($series)) {
                  echo $series;
                }
                ?>">
            </div>
            <?php if (isset($errors['series']))
              echo "<p class='error'>- $errors[series]</p>"; ?>
          </div>
          <div class="box mb-4">
            <div class="input_box">
              <label for="inputAuthor" class="form-label title">المؤلف</label>
              <input type="text" name="author" class="form-control input <?php class_error('author') ?>"
                list="listOfAuthor" id="inputAuthor" placeholder="من هو مؤلف هذا الكتاب؟" title="من هو مؤلف هذا الكتاب؟"
                value="<?php
                if (isset($_POST["author"])) {
                  echo $_POST['author'];
                } elseif (isset($author)) {
                  echo $author;
                } ?>">
              <datalist id="listOfAuthor">
                <?php
                foreach ($authors_value as $value) {
                  echo "<option value='$value->author'>$value->author</option>";
                }
                ?>
              </datalist>
            </div>
            <?php if (isset($errors['author']))
              echo "<p class='error'>- $errors[author]</p>"; ?>
          </div>
          <div class="box mb-4">
            <div class="input_box">
              <label for="inputSubject" class="form-label title_textbox">الموضوعات</label>
              <textarea name="subjects" class="form-control input <?php class_error('subjects') ?>" id="inputSubject"
                rows="3" placeholder='أكتب مواضيع الاساسية مع الفصل بينهم بـــ -'
                title='أكتب مواضيع الاساسية مع الفصل بينهم بـــ -'><?php
                if (isset($_POST["subjects"])) {
                  echo $_POST['subjects'];
                } elseif (isset($subjects)) {
                  echo $subjects;
                } ?></textarea>
            </div>
            <?php if (isset($errors['subjects']))
              echo "<p class='error'>- $errors[subjects]</p>"; ?>
          </div>
          <div class="box mb-4">
            <div class="input_box">
              <label for="inputCode" class="form-label title">الكود</label>
              <input type="number" name="code" min="1" class="form-control input <?php class_error('code') ?>"
                id="inputCode" placeholder="ما هو الكود الخاص بالكتاب؟" title="ما هو الكود الخاص بالكتاب؟" value="<?php
                if (isset($_POST["code"])) {
                  echo $_POST['code'];
                } elseif (isset($code)) {
                  echo $code;
                } ?>">
            </div>
            <?php
            if (isset($errors['code'])) {
              echo "<p class='error'>- $errors[code]</p>";
            } elseif (isset($errors['code_exist'])) {
              echo "<p class='error'>- $errors[code_exist]</p>";
            } ?>
          </div>
          <div class="input_box_group row">
            <div class="box mb-4 col-sm-12 col-md-6">
              <div class="input_box">
                <label for="inputSection" class="form-label title">القسم</label>
                <input type="text" name="section" class="form-control input <?php class_error('section') ?>"
                  id="inputSection" list="listOfSections" placeholder="ما هو اسم هذا القسم الذي ينتمي اليه هذا الكتاب؟"
                  title="ما هو اسم هذا القسم الذي ينتمي اليه هذا الكتاب؟" value="<?php
                  if (isset($_POST["section"])) {
                    echo $_POST['section'];
                  } elseif (isset($section)) {
                    echo $section;
                  } ?>">
                <datalist id="listOfSections">
                  <?php
                  foreach ($sections_value as $value) {
                    echo "<option value='$value->unit_name'>$value->unit_name</option>";
                  }
                  ?>
                </datalist>
              </div>
              <?php if (isset($errors['section']))
                echo "<p class='error'>- $errors[section]</p>"; ?>
            </div>
            <div class="box mb-4 col-sm-12 col-md-6">
              <div class="input_box">
                <label for="inputPublisher" class="form-label title">الناشر</label>
                <input type="text" name="publisher" class="form-control input <?php class_error('publisher') ?>"
                  list="listOfPublisher" id="inputPublisher" placeholder="من هو ناشر هذا الكتاب؟"
                  title="من هو ناشر هذا الكتاب؟" value="<?php
                  if (isset($_POST["publisher"])) {
                    echo $_POST['publisher'];
                  } elseif (isset($publisher)) {
                    echo $publisher;
                  } ?>">
                <datalist id="listOfPublisher">
                  <?php
                  foreach ($publishers_value as $value) {
                    echo "<option value='$value->publisher'>$value->publisher</option>";
                  }
                  ?>
                </datalist>
              </div>
              <?php if (isset($errors['publisher']))
                echo "<p class='error'>- $errors[publisher]</p>"; ?>
            </div>
          </div>
          <div class="input_box_group row">
            <div class="box mb-4 col-sm-12 col-md-6">
              <div class="input_box">
                <label for="inputPart" class="form-label title">رقم الجزء</label>
                <input type="text" name="part_number" min="1" value="N/A" class="form-control input" id="inputPart"
                  placeholder="ما هو رقم هذا الجزاء؟" title="ما هو رقم هذا الجزاء؟" value="<?php
                  if (isset($_POST["part_number"])) {
                    echo $_POST['part_number'];
                  } elseif (isset($part_number)) {
                    echo $part_number;
                  } ?>">
              </div>
            </div>
            <div class="box mb-4 col-sm-12 col-md-6">
              <div class="input_box">
                <label for="inputNumberPages" class="form-label title">عدد الصفحات</label>
                <input type="number" name="nums_page" min="1"
                  class="form-control input <?php class_error('nums_page') ?>" id="inputNumberPages"
                  placeholder="كم عدد صفحات هذا الكتاب؟.." title="كم عدد صفحات هذا الكتاب؟.." value="<?php
                  if (isset($_POST["nums_page"])) {
                    echo $_POST['nums_page'];
                  } elseif (isset($nums_page)) {
                    echo $nums_page;
                  } ?>">
              </div>
              <?php if (isset($errors['nums_page']))
                echo "<p class='error'>- $errors[nums_page]</p>"; ?>
            </div>
          </div>
          <div class="input_box_group row">
            <div class="box mb-4 col-sm-12 col-md-6">
              <div class="input_box">
                <label for="inputNumberCopy" class="form-label title">عدد النسخ</label>
                <input type="number" name="nums_copy" min="1"
                  class="form-control input <?php class_error('nums_copy') ?>" id="inputNumberCopy"
                  placeholder="كم نسخة لديك من هذا الكتاب؟.." title="كم نسخة لديك من هذا الكتاب؟.." value="<?php
                  if (isset($_POST["nums$nums_copy"])) {
                    echo $_POST['nums$nums_copy'];
                  } elseif (isset($nums_copy)) {
                    echo $nums_copy;
                  } ?>">
              </div>
              <?php if (isset($errors['nums_copy']))
                echo "<p class='error'>- $errors[nums_copy]</p>"; ?>
            </div>
            <div class="box mb-4 col-sm-12 col-md-6">
              <div class="input_box">
                <label for="inputUnit" class="form-label title">رقم الوحدة</label>
                <input type="number" name="unit" min="1" class="form-control input <?php class_error('unit') ?>"
                  id="inputUnit" placeholder="ما هي رقم الوحدة؟" title="ما هي رقم الوحدة؟" value="<?php
                  if (isset($_POST["unit"])) {
                    echo $_POST['unit'];
                  } elseif (isset($unit)) {
                    echo $unit;
                  } ?>">
              </div>
              <?php if (isset($errors['unit']))
                echo "<p class='error'>- $errors[unit]</p>"; ?>
            </div>
          </div>
          <div class="box">
            <div class="input_box_group row">
              <div class="box mb-4 col-sm-12 col-md-6">
                <div class="input_box">
                  <label for="inputShelf" class="form-label title">رقم الصف</label>
                  <input type="number" name="shelf" min="1" class="form-control input <?php class_error('shelf') ?>"
                    id="inputShelf" placeholder="ما هو رقم الصف؟" title="ما هو رقم الصف؟" value="<?php
                    if (isset($_POST["shelf"])) {
                      echo $_POST['shelf'];
                    } elseif (isset($shelf)) {
                      echo $shelf;
                    } ?>">
                </div>
                <?php if (isset($errors['shelf']))
                  echo "<p class='error'>- $errors[shelf]</p>"; ?>
              </div>
              <div class="box mb-4 col-sm-12 col-md-6">
                <div class="input_box">
                  <label for="inputNumPosition" class="form-label title">رقم الكتاب في الصف</label>
                  <input type="number" name="num_position" min="1"
                    class="form-control input <?php class_error('num_position') ?>" id="inputNumPosition"
                    placeholder="ما هو رقم هذا الكتاب في الصف؟" title="ما هو رقم هذا الكتاب في الصف؟" value="<?php
                    if (isset($_POST["num_position"])) {
                      echo $_POST['num_position'];
                    } elseif (isset($num_position)) {
                      echo $num_position;
                    } ?>">
                </div>
                <?php if (isset($errors['num_position']))
                  echo "<p class='error'>- $errors[num_position]</p>"; ?>
              </div>
            </div>
          </div>
          <?php
          if (isset($_GET['code'])) {
            echo "<input type='submit' name='send' class='btn btn-outline-success w-100' value='تعديل الكتاب'>";
          } else {
            echo "<input type='submit' name='send' class='btn btn-outline-success w-100' value='أضافة الكتاب'>";
          }
          ?>
        </div>
      </form>
    </div>
  </section>
  <!-- Footer -->
  <?php include("templates/footer.html"); ?>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>