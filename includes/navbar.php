<header class="main-header">
  <nav class="navbar navbar-static-top">
    <div class="container">
      <div class="navbar-header">
        <a href="#" class="navbar-brand"><b>Watashitachi</b></a>
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
          <i class="fa fa-bars"></i>
        </button>
      </div>

      <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
        <ul class="nav navbar-nav">
          <li><a href="index.php"><i class="bi bi-house-door-fill"></i> หน้าหลัก</a></li>

          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="bi bi-bookmark-fill"></i> หมวดหมู่ <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <?php

              $conn = $pdo->open();
              try {
                $stmt = $conn->prepare("SELECT * FROM category");
                $stmt->execute();
                foreach ($stmt as $row) {
                  echo "
                      <li><a href='category.php?category=" . $row['cat_slug'] . "'>" . $row['name'] . "</a></li>
                    ";
                }
              } catch (PDOException $e) {
                echo "There is some problem in connection: " . $e->getMessage();
              }

              $pdo->close();

              ?>
            </ul>
          </li>

          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="bi bi-tags"></i> Tag <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <?php

              $conn = $pdo->open();
              try {
                $stmt = $conn->prepare("SELECT * FROM sub_category");
                $stmt->execute();
                foreach ($stmt as $row) {
                  echo "
                      <li><a href='tag.php?tag=" . $row['tag_slug'] . "'>" . $row['name'] . "</a></li>
                    ";
                }
              } catch (PDOException $e) {
                echo "There is some problem in connection: " . $e->getMessage();
              }

              $pdo->close();

              ?>
            </ul>
          </li>
          <li>
            <a id="btnSearchToggle" class="search-icon" href="#">
              <i class="bi bi-search"></i>
            </a>
          </li>
          <div class="input-group navbar-form navbar-left">
          <input type="text" class="form-control" id="navbarSearchInput" name="keyword" placeholder="ค้นหาการ์ตูน..." style="display: none;">
          <ul id="searchResults" class="dropdown-menu" role="menu"></ul>
        </div>
        </ul>

        

      </div>

      <!-- /.navbar-collapse -->
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li>
            <!-- Menu toggle button -->
            <a href="cart_view.php">
              <i class="bi bi-coin"></i>
            </a>
          </li>
          <?php
          if (isset($_SESSION['user'])) {
            $image = (!empty($user['fb_id'])) ? $user['photo'] : ((!empty($user['photo'])) ? 'images/' . $user['photo'] : 'images/noimage.jpg');
            echo '
                <li>
              <!-- Menu toggle button -->
              <a href="bookmark.php">
                <i class="bi bi-bookmark-heart-fill"></i>
              </a>
                </li>
                <li class="dropdown user user-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="' . $image . '" class="user-image" alt="User Image">
                    <span class="hidden-xs">' . $user['firstname'] . ' ' . $user['lastname'] . '</span>
                  </a>
                  <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                      <img src="' . $image . '" class="img-circle" alt="User Image">
                      <p>
                        ' . 'เหรียญที่มี ' . $user['user_coin'] . ' <i class="bi bi-coin"></i>' . '<br>
                        ' . $user['firstname'] . ' ' . $user['lastname'] . '
                      </p>
                      
                    </li>
                    <li class="user-footer bg-black">
                      <div class="pull-left">
                        <a href="profile.php" class="btn btn-info btn-flat">ดูโปรไฟล์</a>
                      </div>
                      <div class="pull-right">
                        <a href="logout.php" class="btn btn-danger btn-flat">ออกจากระบบ</a>
                      </div>
                    </li>
                  </ul>
                </li>
              ';
          } else {
            echo "
                <li class=' data-toggle='tooltip' title='เข้าสู่ระบบ' '><a id='btnSignin'><i class='bi bi-box-arrow-in-left'></i> เข้าสู่ระบบ</a></li>
              ";
          }
          ?>
        </ul>
      </div>
    </div>
  </nav>
</header>