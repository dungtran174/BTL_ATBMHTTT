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
          <li class="dropdown active">
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
      
      <h3 class="text-center"><span class="label label-danger">Đăng Nhập Số Dễ Bị Tấn Công</span></h3><br>
      
      <?php
        if ($_GET['attempt'] != 1) {
      ?>
      <div class="row">
        <div class="col-sm-offset-2 col-sm-8">
          <form class="form-horizontal" role="form" action="login3.php?attempt=1" method="POST">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Client</label>
              <div class="col-sm-8">
                <input name="client" type="text" class="form-control" id="inputEmail3" placeholder="ID khách hàng">
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">PIN</label>
              <div class="col-sm-8">
                <input name="pin" type="text" class="form-control" id="inputPassword3" placeholder="Mã PIN của bạn">
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
            $client = $_POST['client'];
            $pin = $_POST['pin'];
            
            // Giữ nguyên đoạn code dễ bị tấn công SQL Injection
            $query = sprintf("SELECT * FROM clients WHERE id = %s AND pin = %s;",
                             mysqli_real_escape_string($connection, $client),
                             mysqli_real_escape_string($connection, $pin));
          
            $result = mysqli_query($connection, $query);
          
            if ($result->num_rows > 0) {
                echo "<p class=\"text-center authenticated\">Đăng nhập thành công với ID <strong>" . htmlspecialchars($client) . "</strong></p>";
                
                // Chỉ hiển thị dữ liệu từ kết quả truy vấn ban đầu, không lấy toàn bộ bảng
                echo "<div class=\"data-container\">";
                echo "<h4><i class=\"glyphicon glyphicon-user\"></i> Khách Hàng Trong Cơ Sở Dữ Liệu:</h4>";
                echo "<table class=\"user-data\">";
                echo "<tr><th>ID</th><th>Mã PIN</th></tr>";
                
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['pin'] . "</td>";
                    echo "</tr>";
                }
                
                echo "</table>";
                echo "</div>";
            } else {
                echo "<p class=\"text-center failed\">Sai ID khách hàng hoặc mã PIN.</p>";
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
Nhập <strong>1 OR 1=1</strong> vào ô mã PIN để xem tất cả dữ liệu khách hàng.

Ví dụ chèn mã SQL khác:
- 1 OR 1=1 --
- 1 UNION SELECT 1, pin FROM clients --
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