<?php
require_once 'shared/conn_PDO.php';

?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes, minimum-scale=1.0, maximum-scale=3.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta charset="UTF-8">
  <title>行動管理員後台 CONCIERGE｜登入</title>
  <link rel="icon" href="LOGO/Concierge_icon.ico">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link rel="stylesheet" href="css/index.css">
</head>

<body class="mem-index">
<section class="container">
  <div class="row py-lg-4">
    <div class="col-lg-2 offset-lg-5 col-6 offset-3">
    <a href="index.php"><img src="LOGO/Concierge_1_white.svg" class="img-fluid" alt=""></a>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-4 offset-lg-4">
      <form method="post" action="./mem_login_check.php">
          <div class="login">
            <input type="text" name="mem_mail" class="form-control" required="required" value="" maxlength="20" placeholder="請輸入管理者email">
            <input type="text" name="mem_pwd" class="form-control" required="required" value="" maxlength="20" placeholder="請輸入管理者密碼">
            <input type="submit" name="loginbtn" class="loginbtn" value="登入">
          </div>
          <p class="errmsg-mem"><?php
if (isset($_GET['msg']) && $_GET['msg'] == 1) {echo '帳號或密碼錯誤';}
if (isset($_GET['msg']) && $_GET['msg'] == 2) {echo '請登入管理員帳號';}?></p>
      </form>
    </div>
  </div>
</section>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>