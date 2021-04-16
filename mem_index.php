<?php
require_once('shared/conn_PDO.php');

if ( isset( $_GET['msg'] ) && $_GET['msg'] != '' ) {
  $error = $_GET['msg'];
}

if ( isset( $_SESSION['mem_mail'] ) && $_SESSION['mem_mail'] != '' ) {
  header('Location: order_list.php');
}
function errMsg($error) {
  $msg = '';
  switch($error) {
    case 1:
      $msg = '帳號或密碼錯誤';
      break;
    case 2:
      $msg = '請輸入管理員帳號';
  }
  return $msg;
}
?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes, minimum-scale=1.0, maximum-scale=3.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="css/concierge_index.css" rel="stylesheet">
  <title>行動管理員後台</title>
  <link rel="icon" href="LOGO/Concierge_icon.ico">
  <script src="js/jquery-3.5.1.min.js"></script>
</head>

<body>
  <section class="main">
    <div class="container">
      <div class="logo">
        <img src="LOGO/Concierge_1_white.svg" width:350px;>
      </div>
      <form method="post" action="mem_login_check.php" class="mem-login-area">
        <div class="login">
          <p><input name="mem_mail" id="adminID" type="text" required="required" value="" maxlength="20" placeholder="請輸入管理者email"></p>
          <p><input name="mem_pwd" id="adminpw" type="text" required="required" value="" maxlength="20" placeholder="請輸入管理者密碼"></p>
          <p><input type="submit" name="loginbtn" class="submit-btn" id="loginbtn" value="登入"></p>
        </div>
      </form>
      <p><?php echo errMsg($error); ?></p>
    </div>
  </section>
</body>

</html>
