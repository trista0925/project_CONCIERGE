<?php
//mem_login_check
require_once 'shared/conn_PDO.php';
session_start();
try {
    //準備SQL語法>建立預處理器=========================
    $sql_str = "SELECT *
              FROM mem
              WHERE mem_mail  = :mem_mail
              AND   mem_pwd   = :mem_pwd
              AND   mem_level >= 1";
    $stmt = $conn->prepare($sql_str);

    //接收資料===========================================
    $mem_mail = $_POST['mem_mail'];
    $mem_pwd = $_POST['mem_pwd'];

    //綁定資料===========================================
    $stmt->bindParam(':mem_mail', $mem_mail);
    $stmt->bindParam(':mem_pwd', $mem_pwd);

    //執行==============================================
    $stmt->execute();
    $total = $stmt->rowCount();
    echo $total;

    if ($total == 1) {
        echo $total;
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $_SESSION['mem_id'] = $row['mem_id'];
        $_SESSION['mem_name'] = $row['mem_name'];
        $_SESSION['mem_level'] = $row['mem_level'];
        $_SESSION['mem_mail'] = $row['mem_mail'];

        header('Location: order_list.php');
    } else {
        echo "ERROR";
        header('Location: mem_index.php?page&msg=1');
    }

} catch (PDOException $e) {
    die("Errpr!: " . $e->getMessage());
}
