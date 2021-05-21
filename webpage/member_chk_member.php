<?php
require_once('shared/conn_PDO.php');

//SELECT 查詢這個帳號是否已存在, 如果是, 回傳1
try{
  //準備SQL語法>建立預處理器=========================
  $sql_str = "SELECT *
              FROM mem 
              WHERE mem_mail = :mem_mail";
  $stmt = $conn -> prepare($sql_str);

  //接收資料===========================================
  $mem_mail = $_POST['mem_mail'];

  //綁定資料===========================================
  $stmt -> bindParam( ':mem_mail', $mem_mail );

  //執行==============================================
  $stmt -> execute();
  $total = $stmt -> rowCount();
  
  echo $total;
  
}
catch ( PDOException $e ){
  die("Errpr!: ". $e->getMessage());
}
?>