<?php 
require "db_connect.php";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SQL Injection demo">
    <meta name="author" content="Demo SQL Injection">
    <title>SQL Injection Demo</title>
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
              <li class="active"><a href="login2.php?attempt=2">An Toàn</a></li>
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
      
      <h3 class="text-center"><span class="label label-success">Đăng Nhập Tiêu Chuẩn An Toàn</span></h3><br>
      
      <?php
        if ($_GET['attempt'] != 1) {
      ?>
      <div class="row">
        <div class="col-sm-offset-2 col-sm-8">
          <form class="form-horizontal" role="form" action="login2.php?attempt=1" method="POST">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
              <div class="col-sm-8">
                <input name="username" type="text" class="form-control" id="inputEmail3" placeholder="Username">
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
              <div class="col-sm-8">
                <input name="password" type="text" class="form-control" id="inputPassword3" placeholder="Password">
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
            
            // Sử dụng Prepared Statement để bảo mật
            $query = "SELECT * FROM users WHERE username = ? AND password = ?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "ss", $username, $password);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
          
            if ($result->num_rows > 0) {
                echo "<p class=\"text-center authenticated\">Đăng nhập thành công với tên <strong>" . htmlspecialchars($username) . "</strong></p>";
                
                // Hiển thị dữ liệu người dùng từ database
                echo "<div class=\"data-container\">";
                echo "<h4><i class=\"glyphicon glyphicon-user\"></i> Người Dùng Trong Cơ Sở Dữ Liệu:</h4>";
                echo "<table class=\"user-data\">";
                echo "<tr><th>ID</th><th>Tên người dùng</th><th>Mật khẩu</th></tr>";
                
                $all_users_query = "SELECT * FROM users";
                $all_users_result = mysqli_query($connection, $all_users_query);
                
                while ($row = mysqli_fetch_assoc($all_users_result)) {
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
            <pre>SELECT * FROM users WHERE username = ? AND password = ?</pre>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-sm-12">
          <h4><i class="glyphicon glyphicon-lock"></i> Bảo Mật:</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="highlight">
            <pre>
Trang này sử dụng <strong>Prepared Statements</strong> để ngăn chặn SQL Injection.
Dữ liệu đầu vào được xử lý an toàn thông qua tham số thay vì ghép chuỗi trực tiếp.
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