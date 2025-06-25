<?php 
require "db_connect.php";
?>
<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Demo chèn mã SQL">
    <meta name="author" content="Francesco Borzì">
    <title>Demo Chèn Mã SQL</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/common.css" rel="stylesheet">
  </head>

  <body>
    <div class="container">
      <div class="header hidden-xs">
        <ul class="nav nav-pills pull-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Đăng Nhập Chuẩn<b class="caret"></b></a>
            <ul class="nav dropdown-menu">
              <li><a href="login1.php?attempt=2">Dễ Bị Tấn Công</a></li>
              <li><a href="login2.php?attempt=2">An Toàn</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Đăng Nhập Số<b class="caret"></b></a>
            <ul class="nav dropdown-menu">
              <li><a href="login3.php?attempt=2">Dễ Bị Tấn Công</a></li>
              <li><a href="login4.php?attempt=2">An Toàn</a></li>
            </ul>
          </li>
          <li class="dropdown active">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tìm Kiếm<b class="caret"></b></a>
            <ul class="nav dropdown-menu">
              <li><a href="books1.php">Dễ Bị Tấn Công</a></li>
              <li><a href="books2.php">An Toàn</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Công Cụ<b class="caret"></b></a>
            <ul class="nav dropdown-menu">
              <li><a href="regexp.php">Kiểm Tra Biểu Thức Chính Quy</a></li>
            </ul>
          </li>
        </ul>
        <h3 class="text-muted"><a href="index.php">Demo Chèn Mã SQL</a></h3>
      </div>
      <?php include("mobile-navbar.php"); ?>
      
      <h3 class="text-center"><span class="label label-danger">Tìm Kiếm Dễ Bị Tấn Công</span></h3><br>
      
      <div class="row">
        <div class="col-sm-10">
          <form class="form-inline" role="form" action="books1.php" method="GET">
            <div class="form-group">
              <label class="sr-only" for="exampleInputEmail2">Tiêu đề sách</label>
              <input type="text" name="title" class="form-control" placeholder="Tiêu đề sách">
            </div>
            <div class="form-group">
              <label class="sr-only" for="exampleInputPassword2">Tác giả</label>
              <input type="text" name="author" class="form-control" placeholder="Tác giả">
            </div>
            <button type="submit" class="btn btn-success">Tìm kiếm</button>
            <input type="hidden" name="search" value="1"> <!-- Thêm tham số để xác định tìm kiếm -->
          </form>
        </div>
        <div class="col-sm-2">
          <span class="visible-xs"> </span>
          <form action="books1.php" method="GET" style="display:inline;">
            <input type="hidden" name="all_books" value="1"> <!-- Thay all=1 bằng all_books=1 -->
            <button type="submit" class="btn btn-info">Tất cả sách</button>
          </form>
        </div>
      </div>
      
      <br>
      
      <?php
        $query = null;
        $has_query = false; // Biến kiểm tra có truy vấn từ form hay không

        // Chỉ thực thi khi nhấn "Tất cả sách" từ form (all_books=1) hoặc "Tìm kiếm" (search=1)
        if (isset($_GET['all_books']) && $_GET['all_books'] == 1) {
            $query = "SELECT * FROM books;";
            $has_query = true;
        } else if (isset($_GET['search']) && $_GET['search'] == 1 && (!empty($_GET['title']) || !empty($_GET['author']))) {
            $title = $_GET['title'];
            $author = $_GET['author'];
            $query = sprintf("SELECT * FROM books WHERE title = '%s' OR author = '%s';",
                             $title,
                             $author);
            $has_query = true;
        }
            
        if ($has_query) { // Chỉ hiển thị khi có truy vấn từ form
            $result = mysqli_query($connection, $query);
            
            if ($result && mysqli_num_rows($result) > 0) {
                echo "<div class=\"data-container\">";
                echo "<h4><i class=\"glyphicon glyphicon-book\"></i> Kết Quả Tìm Kiếm:</h4>";
                echo "<table class=\"user-data\">";
                echo "<tr><th>#ID</th><th>Tiêu đề</th><th>Tác giả</th></tr>";
                
                while ($row = mysqli_fetch_row($result)) {
                    echo "<tr>";
                    echo "<td>" . $row[0] . "</td>";
                    echo "<td>" . htmlspecialchars($row[1]) . "</td>";
                    echo "<td>" . htmlspecialchars($row[2]) . "</td>";
                    echo "</tr>";
                }
                
                echo "</table>";
                echo "</div>";
            } else {
                echo "<p class=\"text-center failed\">Không tìm thấy sách nào.</p>";
            }
            
            // Hiển thị truy vấn đã thực thi
            echo "<hr>";
            echo "<div class=\"row\">";
            echo "<div class=\"col-sm-12\">";
            echo "<h4><i class=\"glyphicon glyphicon-console\"></i> Truy Vấn Đã Thực Thi:</h4>";
            echo "</div>";
            echo "</div>";
            echo "<div class=\"row\">";
            echo "<div class=\"col-sm-12\">";
            echo "<div class=\"highlight\">";
            echo "<pre>" . $query . "</pre>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            
            // Hiển thị lỗ hổng
            echo "<hr>";
            echo "<div class=\"row\">";
            echo "<div class=\"col-sm-12\">";
            echo "<h4><i class=\"glyphicon glyphicon-warning-sign\"></i> Lỗ Hổng:</h4>";
            echo "</div>";
            echo "</div>";
            echo "<div class=\"row\">";
            echo "<div class=\"col-sm-12\">";
            echo "<div class=\"vulnerability-box\">";
            echo "<pre>";
            echo "Nhập <strong>' OR id = 10 --</strong> vào ô tiêu đề để lấy sách có id = 10.\n";
            echo "Nhập <strong>' UNION SELECT * FROM users WHERE '1'='1</strong> vào ô tác giả để lấy dữ liệu bảng users.\n\n";
            echo "Ví dụ chèn mã SQL khác:\n";
            echo "- ' OR '1'='1\n";
            echo "- ' OR 1=1 --\n";
            echo "- ' UNION SELECT 1, username, password FROM users --";
            echo "</pre>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
      ?>
      
      <br>
      <?php include("footer.php"); ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>