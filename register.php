<?php
require_once('shared/conn_PDO.php');
session_start();

if ( isset( $_GET['msg'] ) && $_GET['msg'] != '' ) {
  $error = $_GET['msg'];
}
if ( isset( $_SESSION['mem_id'] ) && $_SESSION['mem_id'] != '' ) {
  header('Location: member_index.php');
}

function errMsg($error) {
  $msg = '';
  switch($error) {
    case 1:
      $msg = '帳號或密碼錯誤';
      break;
    case 2:
      $msg = '請輸入會員帳號';
  }
  return $msg;
}
?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes, minimum-scale=1.0, maximum-scale=3.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta charset="UTF-8">
  <title>會員登入 / 註冊</title>
  <link rel="icon" href="LOGO/Concierge_icon.ico">
  <link rel="stylesheet" href="css/index.css">
  <script src="js/jquery-3.5.1.min.js"></script>
</head>

<body>
<section class="container-fluid">
    <div class="row register">
      <div class="col-lg-6 register-leftpic"></div>
      <div class="col-lg-6 register-head">
        <div class="register-info"><a href="index.php"><img src="LOGO/Concierge_1_white.svg" class="img-fluid"></a>
        </div>
          <h3>會員登入 Sign in</h3>
          <form method="post" action="member_login_check.php">
          <input name="mem_mail" id="userID" type="email" required="required" value="" maxlength="50" placeholder="Email / Account 會員帳號">
          <input name="mem_pwd" id="userpw" type="password" required value="" maxlength="20" placeholder="Password 會員密碼">
          <input type="submit" name="loginbtn" class="loginbtn" value="登入">
          </form>
          <p><?php echo errMsg($error); ?></p>
          <h3>註冊會員 Register</h3>
          <form method="post" action="member_addmem_ok.php">
          <input name="mem_mail" id="addID" class="mem_mail add-mail" type="email" required="required" value="" maxlength="50" placeholder="Email Address 電子信箱">
          <div id="msg_mail" class="msg_mail"></div>
          <input name="mem_name" id="addName" class="" type="text" value="" maxlength="30" placeholder="Name 會員名稱">
          <input name="mem_pwd" id="password" class="mem_pwd" type="password" required="required" value="" maxlength="20" placeholder="Password 會員密碼(6至20碼英數字)">
          <div id="msg_mail" class="msg_pwd"></div>
          <input name="addPWagain" id="confirm_password" class="confirm_pwd" type="password" required="required" value="" maxlength="20" placeholder="Password 再次輸入會員密碼">
          <div class="msg_confirm_pwd"></div>
          <input type="hidden" name="process" value="addmem">
          <input type="submit" name="Registerbtn" class="Registerbtn" value="註冊">
          </form>
          <a href="index.php" class="backbtn" type="submit" name="back" value="回上一頁">回上一頁</a>
      </div> 
    </div>
  </section>
</body>
<script>
  var chk_mail = $(".add-mail"); //帳號
  var chk_pwd = $("#addPW"); //密碼
  var chk_confirm_pwd = $("#addPWagain"); //密碼再次輸入
  // var chk_code         = $("#chkcode");       //驗證碼的輸入

  var test_mail = false; //設定帳號的輸入是否正確,預設為否
  var test_pwd = false; //設定密碼的輸入是否正確,預設為否
  var test_confirm_Pwd = false; //設定確認密碼的輸入是否正確,預設為否
  // var test_chk_code    = false;  //設定驗證碼的輸入是否正確,預設為否

  var msg_blue_start = '<span style="color:blue">';
  var msg_blue_end = '</span>';
  var m1 = '<span class="str1"></span>';
  var m0 = '<span class="str0"></span>';

  //--------檢測帳號--------------------------------------------------------
  //當游標離開帳號欄位時
  chk_mail.bind("blur", function() {
    //假如欄位內的值不是空的
    if ($(this).val() != "") {
      console.log($(this).val())
      var chk_mail_val = $(this).val(); //取得目前輸入的內容值
      //以 reg 變數設定檢查E-Mail格式的正則表達式(描述字元規則的檢查物件)
      var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;

      //以 reg 物件檢查 chk_mail_val, 符合規則得到true
      if (!reg.test(chk_mail_val)) {
        $('#msg_mail').html('帳號格式不符合E-Mail！');
        test_mail = false;
      } else {

        //使用AJAX技術取得外部mem_chk_member.php來處理判斷帳號-----------------------------
        $.ajax({
          //呼叫 mem_chk_member.php 進來工作, 以POST方式傳入 chk_mail_val 變數的值
          url: 'member_chk_member.php',
          type: 'post',
          data: {
            mem_mail: chk_mail_val
          }

          //完成ajax的工作後, 執行以下function-------------------------------------------
        }).done(function(msg) { //mem_chk_member.php完成工作會回傳值, 以 msg 收下回傳的值
          console.log('--------' + msg);
          if (msg == 1) { //當收到的值==1, 表示資料庫中已有此帳號
            $('#msg_mail').html('帳號已存在,不能使用！');
            test_mail = false;
          } else {
            $('#msg_mail').html(msg_blue_start + '帳號可以使用！' + msg_blue_end);
            test_mail = true;
          }
          //alert('-----'+msg+'------');
        }); //done end ajax end
      } //if chk end
    } //if 空格 end
  }); //blue end

  //當游標點入帳號欄位時
  chk_mail.bind("focus", function() {
    $('#msg_mail').html(''); //將訊息區塊的內容清除
  })

</script>

</html>
