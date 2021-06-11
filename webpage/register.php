<?php
require_once 'shared/conn_PDO.php';

//判斷是否由mail確認回來的(如果是,則會員身份等級改為2)
if (isset($_GET['mailok']) && $_GET['mailok'] == 1) {
    $mem_mail = $_GET['mem_mail'];
    $mem_chkcode = ['mem_chkcode'];

    try {
        //準備SQL語法>建立預處理器=========================
        $sql_str = "UPDATE mem SET mem_level= 2
                WHERE mem_mail = :mem_mail AND mem_chkcode = :mem_chkcode";
        $stmt = $conn->prepare($sql_str);

        //接收資料===========================================
        $mem_mail = $_GET['mem_mail'];
        $mem_chkcode = $_GET['mem_chkcode'];

        //綁定資料===========================================
        $stmt->bindParam(':mem_mail', $mem_mail);
        $stmt->bindParam(':mem_chkcode', $mem_chkcode);

        //執行==============================================
        $stmt->execute();
        header('Location:?page=register');
    } catch (PDOException $e) {
        die("Errpr!: " . $e->getMessage());
    }
}

session_start();

if (isset($_GET['msg']) && $_GET['msg'] != '') {
    $error = $_GET['msg'];
}
if (isset($_SESSION['mem_id']) && $_SESSION['mem_id'] != '') {
    header('Location: ?page=member_index');
}
?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes, minimum-scale=1.0, maximum-scale=3.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta charset="UTF-8">
  <title>行動管理員 CONCIERGE｜會員登入 / 註冊</title>
  <link rel="icon" href="./images/logo/Concierge_icon.ico">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/animate.css">
</head>

<body>
<section class="container-fluid">
    <div class="row">
      <div class="col-lg-5 d-none d-sm-none d-lg-block register-leftpic"></div>
      <div class="col-lg-7 register no-any-pd">
        <div class="register-logo"><a href="./"><img src="images/logo/Concierge_1_white.svg" class="img-fluid"></a>
        </div>
          <h3 class="pt-lg-4 pt-3 text-center">會員登入 Sign in</h3>
          <form method="post" class="pb-lg-3 pb-1" action="?page=member_login_check">
          <input name="mem_mail" id="userID" type="email" required="required" value="" maxlength="50" placeholder="Email / Account 會員帳號">
          <input name="mem_pwd" id="userpw" type="password" required value="" maxlength="20" placeholder="Password 會員密碼">
          <p class="errmsg-register"><?php
if (isset($_GET['msg']) && $_GET['msg'] == 1) {echo '帳號或密碼錯誤';}
if (isset($_GET['msg']) && $_GET['msg'] == 2) {echo 'Email尚未驗證，請至註冊信箱驗證啟用';}?></p>
          <input type="submit" name="loginbtn" class="loginbtn" value="登入">
          </form>
          <h3 class="pt-lg-3 pt-1 text-center">註冊會員 Register</h3>
          <form method="post" class="pb-lg-4 pb-3" action="?page=member_addmem_ok">
          <input name="mem_mail" id="mem_mail" class="mem_mail" type="email" required="required" value="" maxlength="50" placeholder="Email Address 電子信箱">
          <div id="msg_mail" class="msg_mail"></div>
          <input name="mem_name" id="addName" class="" type="text" value="" maxlength="30" placeholder="Name 會員名稱">
          <input name="mem_pwd" id="mem_pwd" class="mem_pwd" type="password" required="required" value="" maxlength="20" placeholder="Password 會員密碼(6至20碼英數字)">
          <div id="msg_pwd" class="msg_pwd"></div>
          <input name="confirm_pwd" id="confirm_pwd" class="confirm_pwd" type="password" required="required" value="" maxlength="20" placeholder="Password 再次輸入會員密碼">
          <div id="msg_confirm_pwd" class="msg_confirm_pwd"></div>
          <input type="hidden" name="process" value="addmem">
          <input type="submit" name="Registerbtn" class="Registerbtn" value="註冊">
          </form>
          <a href="./" class="back-btn" name="back" value="回上一頁">回上一頁</a>
      </div>
    </div>
  </section>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  <script src="js/jquery-3.5.1.min.js"></script>
  <script src="js/check_mem_mail.js"></script>
</body>
</html>
