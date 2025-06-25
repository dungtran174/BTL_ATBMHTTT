<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SQL Injection demo">
    <meta name="author" content="Kiểm Chứng Phần Mềm">

    <title>SQL Injection Demo</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
      body {
        background-color: #f5f5f5;
        padding-top: 20px;
        padding-bottom: 20px;
      }
      .container {
        max-width: 1000px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        padding: 20px 30px;
      }
      .header {
        margin-bottom: 30px;
        border-bottom: 1px solid #e5e5e5;
        padding-bottom: 15px;
      }
      .jumbotron {
        background-color: #f9f9f9;
        text-align: center;
        padding: 30px;
        margin-bottom: 30px;
        border-radius: 5px;
        border: 1px solid #e3e3e3;
      }
      .jumbotron h1 {
        color: #d9534f;
        margin-bottom: 20px;
      }
      .jumbotron h2 {
        color: #333;
        margin-bottom: 30px;
        font-size: 24px;
      }
      .feature-box {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
      }
      .feature-box h3 {
        color: #337ab7;
        margin-top: 0;
      }
      .feature-box ul {
        padding-left: 20px;
      }
      .feature-box li {
        margin-bottom: 8px;
      }
      .demo-option {
        background-color: #f5f5f5;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        text-align: center;
      }
      .demo-option:hover {
        background-color: #e9e9e9;
      }
      .demo-option h4 {
        margin-top: 0;
      }
      .nav-pills > li.active > a, .nav-pills > li.active > a:focus, .nav-pills > li.active > a:hover {
        background-color: #337ab7;
      }
      .icon {
        font-size: 48px;
        color: #337ab7;
        margin-bottom: 15px;
      }
    </style>
  </head>

  <body>

    <div class="container">
      <div class="header hidden-xs">
        <ul class="nav nav-pills pull-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Standard Login<b class="caret"></b></a>
            <ul class="nav dropdown-menu">
            <li><a href="login1.php?attempt=2">Vulnerable</a></li>
            <li><a href="login2.php?attempt=2">Secure</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Numeric Login<b class="caret"></b></a>
            <ul class="nav dropdown-menu">
              <li><a href="login3.php?attempt=2">Vulnerable</a></li>
              <li><a href="login4.php?attempt=2">Secure</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Search<b class="caret"></b></a>
            <ul class="nav dropdown-menu">
              <li><a href="books1.php?all=1">Vulnerable</a></li>
              <li><a href="books2.php?all=1">Secure</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tools<b class="caret"></b></a>
            <ul class="nav dropdown-menu">
              <li><a href="regexp.php">Regular Expression Checker</a></li>
            </ul>
          </li>
        </ul>
        <h3 class="text-muted"><a href="index.php">SQL Injection Demo</a></h3>
      </div>
      <?php include("mobile-navbar.php"); ?>

      <div class="jumbotron">
        <h1>SQL Injection Demo</h1>
        <h2>Kiểm Chứng Phần Mềm</h2>
        <p class="lead">Đây là ứng dụng minh họa các lỗ hổng SQL Injection và cách phòng chống chúng</p>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="feature-box">
            <h3><i class="glyphicon glyphicon-warning-sign"></i> SQL Injection là gì?</h3>
            <p>SQL Injection là một kỹ thuật tấn công phổ biến, cho phép kẻ tấn công chèn mã SQL độc hại vào câu truy vấn của ứng dụng web. Điều này có thể dẫn đến:</p>
            <ul>
              <li>Đánh cắp thông tin nhạy cảm như mật khẩu, dữ liệu cá nhân</li>
              <li>Xóa hoặc sửa đổi dữ liệu trong cơ sở dữ liệu</li>
              <li>Chiếm quyền điều khiển hệ thống</li>
              <li>Bỏ qua xác thực người dùng</li>
            </ul>
          </div>
        </div>
        <div class="col-md-6">
          <div class="feature-box">
            <h3><i class="glyphicon glyphicon-lock"></i> Cách ngăn chặn SQL Injection</h3>
            <p>Có nhiều phương pháp để ngăn chặn tấn công SQL Injection:</p>
            <ul>
              <li>Sử dụng Prepared Statements với tham số ràng buộc</li>
              <li>Sử dụng Stored Procedures</li>
              <li>Escape các ký tự đặc biệt trong đầu vào người dùng</li>
              <li>Áp dụng nguyên tắc quyền tối thiểu cho tài khoản cơ sở dữ liệu</li>
              <li>Xác thực và lọc dữ liệu đầu vào</li>
            </ul>
          </div>
        </div>
      </div>

      <h3 class="text-center">Demo tấn công SQL Injection</h3>
      <div class="row">
        <div class="col-md-4">
          <div class="demo-option">
            <div class="icon"><i class="glyphicon glyphicon-user"></i></div>
            <h4>Standard Login</h4>
            <p>Demo tấn công SQL Injection qua form đăng nhập tiêu chuẩn</p>
            <a href="login1.php?attempt=2" class="btn btn-primary">Vulnerable</a>
            <a href="login2.php?attempt=2" class="btn btn-success">Secure</a>
          </div>
        </div>
        <div class="col-md-4">
          <div class="demo-option">
            <div class="icon"><i class="glyphicon glyphicon-th-list"></i></div>
            <h4>Numeric Login</h4>
            <p>Demo tấn công SQL Injection qua form đăng nhập số</p>
            <a href="login3.php?attempt=2" class="btn btn-primary">Vulnerable</a>
            <a href="login4.php?attempt=2" class="btn btn-success">Secure</a>
          </div>
        </div>
        <div class="col-md-4">
          <div class="demo-option">
            <div class="icon"><i class="glyphicon glyphicon-search"></i></div>
            <h4>Search</h4>
            <p>Demo tấn công SQL Injection qua form tìm kiếm</p>
            <a href="books1.php?all=1" class="btn btn-primary">Vulnerable</a>
            <a href="books2.php?all=1" class="btn btn-success">Secure</a>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-12">
          <div class="feature-box">
            <h3><i class="glyphicon glyphicon-education"></i> Mục đích học tập</h3>
            <p>Đây là một ứng dụng demo được tạo ra chỉ với mục đích giáo dục. Nó giúp sinh viên và chuyên gia bảo mật:</p>
            <ul>
              <li>Hiểu cách thức hoạt động của các cuộc tấn công SQL Injection</li>
              <li>Học cách phát hiện và ngăn chặn các lỗ hổng SQL Injection</li>
              <li>Thực hành kỹ năng bảo mật ứng dụng web</li>
              <li>Phát triển kỹ năng lập trình an toàn</li>
            </ul>
            <p class="text-danger"><strong>Lưu ý:</strong> Không nên áp dụng các kỹ thuật tấn công từ demo này vào bất kỳ hệ thống nào mà không có sự cho phép.</p>
          </div>
        </div>
      </div>

      <?php include("footer.php"); ?>

    </div> <!-- /container -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>