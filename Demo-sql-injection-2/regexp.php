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
    <meta name="author" content="Francesco Borzì">
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
              <li><a href="books1.php?all=1">Dễ Bị Tấn Công</a></li>
              <li><a href="books2.php?all=1">An Toàn</a></li>
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

      <h3 class="text-center"><span class="label label-info">Kiểm Tra Biểu Thức Chính Quy</span></h3><br>

      <?php
      $pattern = "";
      $subject = "";
      $result = null;
      if (isset($_GET['pattern']) && isset($_GET['subject'])) {
          $pattern = $_GET['pattern'];
          $subject = $_GET['subject'];

          if (!empty($pattern) && !empty($subject)) {
              if (@preg_match($pattern, $subject) !== false) {
                  if (preg_match($pattern, $subject)) {
                      $result = "Chuỗi khớp với biểu thức!";
                      $result_class = "authenticated";
                  } else {
                      $result = "Chuỗi không khớp với biểu thức!";
                      $result_class = "failed";
                  }
              } else {
                  $result = "Biểu thức chính quy không hợp lệ!";
                  $result_class = "failed";
              }
          } else {
              $result = "Vui lòng nhập cả biểu thức và chuỗi!";
              $result_class = "failed";
          }
      }
      ?>

      <div class="row">
        <div class="col-sm-offset-2 col-sm-8">
          <form class="form-horizontal" role="form" action="regexp.php" method="GET">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Biểu thức</label>
              <div class="col-sm-8">
                <input value="<?= htmlspecialchars($pattern) ?>" name="pattern" type="text" class="form-control" id="inputEmail3" placeholder="Nhập biểu thức chính quy giữa / và /">
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Chuỗi</label>
              <div class="col-sm-8">
                <input value="<?= htmlspecialchars($subject) ?>" name="subject" type="text" class="form-control" id="inputPassword3" placeholder="Nhập chuỗi cần kiểm tra">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Kiểm tra</button>
              </div>
            </div>
          </form>

          <?php if ($result !== null) { ?>
            <p class="text-center <?= $result_class ?>"><?= $result ?></p>
          <?php } ?>
        </div>
      </div>

      <!-- <hr>
      <div class="row">
        <div class="col-sm-12">
          <h4><i class="glyphicon glyphicon-file"></i> Mã PHP Đã Thực Thi:</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="highlight">
            <pre>
$pattern = "<?= htmlspecialchars($pattern) ?>";
$subject = "<?= htmlspecialchars($subject) ?>";

if (!empty($pattern) && !empty($subject)) {
    if (@preg_match($pattern, $subject) !== false) {
        if (preg_match($pattern, $subject)) {
            echo "Chuỗi khớp với biểu thức!";
        } else {
            echo "Chuỗi không khớp với biểu thức!";
        }
    } else {
        echo "Biểu thức chính quy không hợp lệ!";
    }
} else {
    echo "Vui lòng nhập cả biểu thức và chuỗi!";
}
            </pre>
          </div>
        </div>
      </div>

      <hr> -->
      
      <div class="row">
        <div class="col-sm-12">
          <h4><i class="glyphicon glyphicon-info-sign"></i> Tham Khảo Biểu Thức Chính Quy:</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="highlight">
            <pre>
[abc]     Một ký tự: a, b hoặc c
[^abc]    Bất kỳ ký tự nào trừ a, b, hoặc c
[a-z]     Bất kỳ ký tự nào trong khoảng a-z
[a-zA-Z]  Bất kỳ ký tự nào trong khoảng a-z hoặc A-Z
^         Đầu dòng
$         Cuối dòng
\A        Đầu chuỗi
\z        Cuối chuỗi
.         Bất kỳ ký tự nào
\s        Bất kỳ ký tự khoảng trắng nào
\S        Bất kỳ ký tự không phải khoảng trắng
\d        Bất kỳ chữ số nào
\D        Bất kỳ ký tự không phải chữ số
\w        Bất kỳ ký tự từ (chữ, số, gạch dưới)
\W        Bất kỳ ký tự không phải từ
\b        Ranh giới từ
(...)     Bắt toàn bộ nội dung trong ngoặc
(a|b)     a hoặc b
a?        Không hoặc một a
a*        Không hoặc nhiều a
a+        Một hoặc nhiều a
a{3}      Chính xác 3 a
a{3,}     3 hoặc nhiều a hơn
a{3,6}    Từ 3 đến 6 a
            </pre>
          </div>
          <p>Thông tin chi tiết: <a href="http://www.php.net/manual/en/regexp.introduction.php">http://www.php.net/manual/en/regexp.introduction.php</a></p>
        </div>
      </div>

      <hr>
      <div class="row">
        <div class="col-sm-12">
          <h4><i class="glyphicon glyphicon-link"></i> Tham Khảo Hàm <span style="color: #369">preg_match()</span>:</h4>
          <a href="http://www.php.net/manual/en/function.preg-match.php">http://www.php.net/manual/en/function.preg-match.php</a>
        </div>
      </div>

      <hr>
      <div class="row">
        <div class="col-sm-12">
          <hhistoric4><i class="glyphicon glyphicon-ok"></i> Ví Dụ:</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="highlight">
            Biểu thức chính quy <strong>/^[a-z]{2,4}+[0-9]{2}$/</strong> khớp với chuỗi bắt đầu bằng 2-4 ký tự chữ (a-z) và kết thúc bằng 2 chữ số (0-9).
          </div>
        </div>
      </div>

      <br>
      <?php include("footer.php"); ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>