<?php
include("db/connect.php");
include("functions/permissions.php");

// Get Units
$sql = $db->prepare("SELECT unit.num, unit.unit_name FROM `unit` ORDER BY `unit`.`num` ASC;");
$sql->execute();
$units = $sql->fetchAll(PDO::FETCH_OBJ);

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
  <link rel="shortcut icon" href="image/logo.png" type="image/x-icon" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&display=swap"
    rel="stylesheet" />

  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <link rel="stylesheet" href="css/all.min.css" />
  <link rel="stylesheet" href="css/main.css" />
  <link rel="stylesheet" href="css/sections.css" />
  <title>اقسام الكتب | مكتبة البابا أثناسيوس</title>
</head>

<body>
  <!-- Start Header Code -->
  <?php include("templates/header.php"); ?>
  <!-- Content -->
  <section class="sections">
    <div class="container">
      <div class="title_section">
        <h2 class="title"><i class="fa-solid fa-book-medical"></i> أقسام الكتب</h2>
      </div>
      <div class="parent">
        <?php
        foreach ($units as $unit) {
          ?>
          <details class="box">
            <summary>
              <div class="title"><i class="fa-solid fa-book-bookmark"></i>
                <?php echo $unit->unit_name; ?>
              </div>
              <div class="position">
                <?php echo $unit->num; ?>
              </div>
            </summary>
            <?php
            $sql = $db->prepare("SELECT shelf_name, shelf_number FROM `shelf` WHERE unit_number = $unit->num;");
            $sql->execute();
            $shelfs = $sql->fetchAll(PDO::FETCH_OBJ);
            foreach ($shelfs as $sh) {
              ?>
              <a href="search.php?select=shelf_number&page=1&search=أبحث&title=<?php echo $sh->shelf_number; ?>&unit=<?php echo $unit->num; ?>"
                class="type">
                <div class="title">
                  <?php echo $sh->shelf_name; ?>
                </div>
                <div class="position">
                  <?php echo $sh->shelf_number; ?>
                </div>
              </a>
              <?php
            } ?>
          </details>
          <?php
        } ?>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php include("templates/footer.html"); ?>

  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>