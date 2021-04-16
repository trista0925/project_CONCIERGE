<?php
require_once('shared/conn_PDO.php');

if ( isset( $_GET['msg'] ) && $_GET['msg'] == '1' ) { 
  $error = 1;
}

?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>mem_login</title>
  <link rel="icon" href="LOGO/Concierge_icon.ico">
  <style>
    table { width: 100%; }
    th, td { text-align: center; }
    .pagenation {
      width: 225px;
      margin: 0 auto;
      text-align: center;
    }
  </style>
  <script src="js/jquery-3.5.1.min.js"></script>
</head>
<body>
  <main>
    <h1>會員訂單管理</h1>
    <p>這組是管理員帳號 ===>  ts009@gmail.com / ts1234</p>
    <form method="post" action="mem_login_check.php" class="mem-login-area">
      <input type="text" name="mem_mail" class="mem_mail" placeholder="請輸入EMail為帳號" required/>
      <input type="password" name="mem_pwd" class="mem_pwd" placeholder="請輸入密碼...." required/>
      <input type="submit" class="submit-btn" value="進入後台">
    </form>
    <?php 
      if ($error) {
        echo "帳號或密碼錯誤";
      } 
    ?>
  </main>
</body>
</html>