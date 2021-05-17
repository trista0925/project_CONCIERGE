<?php
require_once 'shared/conn_PDO.php';
//如果來自註冊表單送來的資料(將資料存入資料庫mem資料表)
if (isset($_POST['process']) && $_POST['process'] == 'addmem') {
    try {
        //準備SQL語法>建立預處理器=========================
        $sql_str = "INSERT INTO mem ( mem_name, mem_mail, mem_pwd,mem_chkcode )
                        VALUES ( :mem_name, :mem_mail, :mem_pwd,:mem_chkcode )";
        $stmt = $conn->prepare($sql_str);

        //接收資料===========================================
        $mem_mail = $_POST['mem_mail'];
        $mem_pwd = $_POST['mem_pwd'];
        $mem_mail_name = explode("@", $mem_mail);
        $mem_name = (isset($_POST['mem_name']) && $_POST['mem_name'] != '') ? $_POST['mem_name'] : $mem_mail_name[0];
        $mem_chkcode = getchkcode();

        //綁定資料===========================================
        $stmt->bindParam(':mem_name', $mem_name);
        $stmt->bindParam(':mem_mail', $mem_mail);
        $stmt->bindParam(':mem_pwd', $mem_pwd);
        $stmt->bindParam(':mem_chkcode', $mem_chkcode);

        //執行==============================================
        $stmt->execute();
        //$msg變數, 代表了發信成功與否
        $msg = 1;
        //執行sendMail(收信者信箱, 會員名稱, 信件驗證碼), 負責發信的自定函式
        $result2 = sendMail($mem_mail, $mem_name, $mem_chkcode);
        //如果$result2不等於1, 表示發信不成功, 那麼$msg就等於0
        if ($result2 != 1) {$msg = 0;}

        header('Location:?page&msg=' . $msg . '&r=' . $result2);

    } catch (PDOException $e) {
        die("Errpr!: 註冊失敗......" . $e->getMessage());
    }
}
//如果接收到msg的訊息是1時, 表示註冊成功, 發信也成功了
if (isset($_GET['msg']) && $_GET['msg'] == 1) {
    header('Location: registerfinish.php');
}

//如果接收到msg的訊息是0時, 表示註冊成功, 但發信失敗了
if (isset($_GET['msg']) && $_GET['msg'] == 0) {
    echo '<h2>失敗, 請重新申請.......</h2>';
}
//負責發信的自定函式(收件者信箱, 收件者名稱, 確認信的驗證碼)
function sendMail($mailto, $name, $chkcode)
{
    //信件主旨
    $subject = "=?UTF-8?B?" . base64_encode('行動管理員CONCIERGE會員啟用通知信') . "?=";
    //信件內容
    $content = '<h3 style="letter-spacing: 0.06rem;color: #005F69;">會員啟用通知信</h3>'
        . '<p style="letter-spacing: 0.06rem;color: #333333;">Hello！' . $name . '</p>'
        . '<p style="letter-spacing: 0.06rem;color: #333333;">感謝您加入行動管理員CONCIERGE</p>'
        . '<p style="letter-spacing: 0.06rem;color: #333333;">請點選以下連結完成帳號啟用</p>'
        . '<p style="letter-spacing: 0.06rem;color: #333333;"><a href="http://localhost/project_CONCIERGE/register.php?page&mailok=1&mem_mail=' . $mailto . '&mem_chkcode=' . $chkcode . '">啟用帳號</a></p>'
        . '<p style="letter-spacing: 0.06rem;color: #333333;">*此信件為系統自動發送，請勿直接回覆信件*</p>';
    //信件檔頭資訊
    $header = "From: server@gmail.com\r\n";
    $header .= "Content-type: text/html; charset=utf8";

    //mail(收件者,信件主旨,信件內容,信件檔頭資訊)
    $result = mail($mailto, $subject, $content, $header);
    return $result;
}
//負責取得驗證碼的自定函式
function getchkcode()
{
    $number = ''; //存放答案的變數
    $number_len = 6; //決定驗證碼的長度
    $stuff = '1356724890'; //取樣的來源
    $stuff_last = strlen($stuff) - 1; //取樣來源最後一個字元的索引編碼

    //依驗證碼長度繞迴圈
    for ($i = 0; $i < $number_len; $i++) {
        //$number變數依序串接取得的字元
        //substr( 取樣來源的字串, 自第幾個字元開始, 取出幾個字元 )
        //mt_rand( 起始值, 結束值 ) 在指定的範圍內取得隨機值
        $number .= substr($stuff, mt_rand(0, $stuff_last), 1);
    }
    return $number; //回傳驗證碼
}
