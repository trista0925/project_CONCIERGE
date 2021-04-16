<?php
require_once('shared/conn_PDO.php');
if( isset($_POST['process']) && $_POST['process']=='addmem' ){
  try{
    //準備SQL語法>建立預處理器=========================
    $sql_str = "INSERT INTO mem ( mem_name, mem_mail, mem_pwd ) 
                        VALUES ( :mem_name, :mem_mail, :mem_pwd )";
    $stmt = $conn -> prepare($sql_str);

    //接收資料===========================================
    $mem_mail = $_POST['mem_mail'];
    $mem_pwd  = $_POST['mem_pwd'];
    $mem_mail_name = explode("@", $mem_mail);
    // var_dump($mem_mail_name);
    $mem_name = (isset($_POST['mem_name']) && $_POST['mem_name'] != '')? $_POST['mem_name'] : $mem_mail_name[0];
    // var_dump($mem_name);
    // $mem_chkcode = getchkcode();

    //綁定資料===========================================
    $stmt -> bindParam( ':mem_name' , $mem_name );
    $stmt -> bindParam( ':mem_mail' , $mem_mail );
    $stmt -> bindParam( ':mem_pwd'  , $mem_pwd  );
    // $stmt -> bindParam( ':mem_chkcode'  , $mem_chkcode );

    //執行==============================================
    $stmt -> execute();

    $msg = 1;
    // $result2 = sendMail($mem_mail, $mem_name, $mem_chkcode);
    // $result2 = sendMail($mem_mail, $mem_name);
    $result2 = 1;
    if($result2!=1){ $msg = 0; }

    header('Location:?&msg='.$msg.'&r='.$result2);
    // header('Location: registe  rfinish.php');
  }
  catch ( PDOException $e ){
    die("Errpr!: 註冊失敗......". $e->getMessage());
  }
}



if( isset($_GET['msg']) && $_GET['msg']==1 ){

  // echo '<h2>感謝您註冊新會員成功！<br>
  //           請前往郵件信箱收信！<br>
  //           點選驗證連結再回到網站！<br></h2>';
  header('Location: registerfinish.php');
}
if( isset($_GET['msg']) && $_GET['msg']==0 ){
  echo '<h2>失敗, 請重新申請.......</h2>';
}



function sendMail($mailto,$name){

  $subject = "=?UTF-8?B?".base64_encode('CONCIERGE會員功能啟用通知')."?=";

  $content = $name.'您好, 感謝申請會員<br>'
    .'CONCIERGE會員功能啟用通知<br>'

    // .'請點選<a href="localhost/TS_PHP_20201201/?page=mem_login&mailok=1&mem_mail='
    // .$mailto.'&mem_chkcode='.$chkcode.'">此連結回覆確認信箱</a><br>'

    .'請點選<a href="localhost/CONCIERGE/?&mem_mail='.$mailto.'&mailok=1">此連結回覆確認信箱</a><br>'

    .'此信件為系統自動發送, 請勿點選回覆信件'; 

  $header = "From: server@gmail.com\r\n";
  $header .= "Content-type: text/html; charset=utf8";

  //mail(收件者,信件主旨,信件內容,信件檔頭資訊)
  $result = mail($mailto, $subject, $content, $header);
  return $result;
}

function getchkcode(){
  $number = '';
  $number_len = 6;
  $stuff = '1356724890';
  $stuff_last = strlen($stuff) - 1;

  for ($i = 0; $i < $number_len; $i++) {
    $number .= substr($stuff, mt_rand(0, $stuff_last), 1);
  }
  return $number;
}
?>




