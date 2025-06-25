<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "db_connect.php";
?>
<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Demo chèn mã SQL">
    <meta name="author" content="Demo SQL Injection">
    <title>Demo Chèn Mã SQL</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/common.css" rel="stylesheet">
  </head>

  <body>
    <div class="container">
      <div class="header hidden-xs">
        <ul class="nav nav-pills pull-right">
          <li class="active dropdown">
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
          <li class="dropdown">
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
      
      <h3 class="text-center"><span class="label label-danger">Đăng Nhập Chuẩn Dễ Bị Tấn Công</span></h3><br>
      
      <?php
        if ($_GET['attempt'] != 1) {
      ?>
      <div class="row">
        <div class="col-sm-offset-2 col-sm-8">
          <form class="form-horizontal" role="form" action="login1.php?attempt=1" method="POST">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
              <div class="col-sm-8">
                <input name="username" type="text" class="form-control" id="inputEmail3" placeholder="Tên người dùng">
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
              <div class="col-sm-8">
                <input name="password" type="text" class="form-control" id="inputPassword3" placeholder="Mật khẩu">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Đăng Nhập</button>
              </div>
            </div>
          </form>
        </div>  
      </div>
      
      <?php
        } else {
            $username = $_POST['username'];
            $password = $_POST['password'];
            
            $query = sprintf("SELECT * FROM users WHERE username = '%s' AND password = '%s';",
                             $username,
                             $password);
          
            // Bật chế độ báo lỗi nghiêm ngặt
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            
            try {
                $result = mysqli_query($connection, $query);
            } catch (mysqli_sql_exception $e) {
                echo "<p class=\"text-center failed\">Lỗi SQL: " . $e->getMessage() . "</p>";
                echo "<div class=\"highlight\"><pre>Truy vấn: $query</pre></div>";
                exit;
            }
          
            if ($result->num_rows > 0) {
                echo "<p class=\"text-center authenticated\">Đăng nhập thành công với tên <strong>" . htmlspecialchars($username) . "</strong></p>";
                
                echo "<div class=\"data-container\">";
                echo "<h4><i class=\"glyphicon glyphicon-user\"></i> Người Dùng Trong Cơ Sở Dữ Liệu:</h4>";
                echo "<table class=\"user-data\">";
                echo "<tr><th>ID</th><th>Tên Người Dùng</th><th>Mật Khẩu</th></tr>";
                
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['password'] . "</td>";
                    echo "</tr>";
                }
                
                echo "</table>";
                echo "</div>";
            } else {
                echo "<p class=\"text-center failed\">Sai tên người dùng hoặc mật khẩu.</p>";
            }
      ?>
      
      <hr>
      <div class="row">
        <div class="col-sm-12">
          <h4><i class="glyphicon glyphicon-console"></i> Truy Vấn Đã Thực Thi:</h4>
        </div>
      </div>
      
      <div class="row">
        <div class="col-sm-12">
          <div class="highlight">
            <pre><?= $query ?></pre>
          </div>
        </div>
      </div>
      
      <hr>
      <div class="row">
        <div class="col-sm-12">
          <h4><i class="glyphicon glyphicon-warning-sign"></i> Lỗ Hổng:</h4>
        </div>
      </div>
      
      <div class="row">
        <div class="col-sm-12">
          <div class="vulnerability-box">
            <pre>
Nhập <strong>' OR 1=1 #</strong> vào tên người dùng hoặc mật khẩu để xem tất cả dữ liệu người dùng.

Các ví dụ chèn mã SQL khác:
- admin' --
- ' OR '1'='1 
- ' OR 1=1 --
- ' UNION SELECT 1, username, password FROM users --
            </pre>
          </div>
        </div>
      </div>
      
      <?php } ?>
      
      <br>
      <?php include("footer.php"); ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>