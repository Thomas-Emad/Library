<header>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="index.php"><img src="image/layout/logo.png" class="logo" alt="Logo" /></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">
              <i class="fa-solid fa-house-chimney"></i>
              الرئيسية</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="sections.php">
              <i class="fa-solid fa-book-bible"></i>
              أقسام الكتب</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="publications.php">
              <i class="fa-solid fa-envelopes-bulk"></i>
              المنشورات</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#search" data-bs-toggle="modal">
              <i class="fa-solid fa-magnifying-glass"></i>
              البحث</a>
          </li>
        </ul>
        <?php
        if (isset($_COOKIE['username'])) {
          include('db/connect.php');
          $sql = $db->prepare("SELECT username, img FROM `users` WHERE username = " . $_COOKIE['username']);
          $sql->execute();
          $user_log = $sql->fetch(PDO::FETCH_OBJ);
          if (empty($user_log)) {
            header("Location: logout.php");
            exit();
          }
          $img = $user_log->img;
          ?>
          <li class="nav-item dropdown">
            <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="image/users/<?php echo $img; ?>" class="img_profile" alt="profile image user"
                onerror="this.onerror=null;this.src=`image/layout/someone.jpg`;" />
            </a>
            <ul class="dropdown-menu dropdown-menu-sm-end dropdown-menu-lg-start">
              <li><a class="dropdown-item" href="profile.php">الملف الشخصي</a></li>
              <li>
                <?php
                if (show_part('admin')) {
                  echo "
                    <hr class='dropdown-divider' />
                    <li>
                      <a class='dropdown-item' href='main-book.php'>اضافة كتاب</a>
                    </li>
                  ";
                }
                ?>
              </li>
              <?php
              if (show_part('owner')) {
                echo "
                    <li>
                      <a class='dropdown-item' href='users.php'>المستخدمين</a>
                    </li>
                    <hr class='dropdown-divider' />
                    <li>
                      <a class='dropdown-item' href='word_day.php'>كلمة اليوم</a>
                    </li>
                  ";
              }
              ?>
              <li>
                <hr class="dropdown-divider" />
              </li>
              <li>
                <a class="dropdown-item" href="logout.php">تسحيل خروج</a>
              </li>
            </ul>
          </li>
          <?php
        } else {
          ?>
          <div class="buttons">
            <a href="log.php?url=login" class="btn-log">تسجيل دخول</a>
          </div>
          <?php
        }
        ?>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="search" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="top: 70px">
          <form action="search.php" method='GET' class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">
                <i class="fa-solid fa-magnifying-glass"></i>
                بماذا تريد ان تبحث؟
              </h1>
              <button type="button" class="close_modal" data-bs-dismiss="modal" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
              </button>
            </div>
            <div class="modal-body">
              <input type="text" class="form-control input_modal" name="title" placeholder="اكتب هنا ما تريد..."
                required />
              <input type="text" class="form-control input_modal" name="select" placeholder="اكتب هنا ما تريد..."
                value="all" hidden />
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                الغاء
              </button>
              <input type="submit" class="btn btn-primary success_modal" name="search" value="بحث...">
            </div>
          </form>
        </div>
      </div>
    </div>
  </nav>
</header>