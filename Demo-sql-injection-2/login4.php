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
      
      <h3 class="text-center"><span class="label label-success">Đăng Nhập Số An Toàn</span></h3><br>
      
      <?php
        if ($_GET['attempt'] != 1) {
      ?>
      <div class="row">
        <div class="col-sm-offset-2 col-sm-8">
          <form class="form-horizontal" role="form" action="login4.php?attempt=1" method="POST">
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
          
            if (is_numeric($client) && is_numeric($pin)) {
                // Sử dụng Prepared Statement để bảo mật
                $query = "SELECT * FROM clients WHERE id = ? AND pin = ?";
                $stmt = mysqli_prepare($connection, $query);
                mysqli_stmt_bind_param($stmt, "ii", $client, $pin); // "ii" vì cả client và pin đều là số
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                
                if ($result->num_rows > 0) {
                    echo "<p class=\"text-center authenticated\">Đăng nhập thành công với ID <strong>" . htmlspecialchars($client) . "</strong></p>";
                    
                    // Chỉ hiển thị dữ liệu từ kết quả truy vấn ban đầu
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
            } else {
                echo "<p class=\"text-center failed\">ID khách hàng và mã PIN phải là số.</p>";
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
            <pre>SELECT * FROM clients WHERE id = ? AND pin = ?</pre>
          </div>
        </div>
      </div>
      
      <hr>
      <div class="row">
        <div class="col-sm-12">
          <h4><i class="glyphicon glyphicon-lock"></i> Bảo Mật:</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="highlight">
            <pre>
Trang này sử dụng <strong>Prepared Statements</strong> và kiểm tra <strong>is_numeric()</strong>
để ngăn chặn chèn mã SQL. Chỉ chấp nhận đầu vào là số nguyên.
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