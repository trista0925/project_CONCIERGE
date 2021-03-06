<?php
// header('Content-Type: application/json; charset=UTF-8');
require_once 'shared/conn_PDO.php';
session_start();
try {
    if (isset($_POST['process']) && $_POST['process'] == 'insert') {
        $str = "INSERT INTO  orderlist (
              order_mem_id, order_name, order_mail, order_store_id, order_store_name,  order_phone,
              order_tele, order_size, order_time_arrive, order_time_get, order_memo)
    VALUES ( :order_mem_id, :order_name, :order_mail, :order_store_id, :order_store_name, :order_phone,
             :order_tele, :order_size, :order_time_arrive, :order_time_get, :order_memo)";
        $stmt = $conn->prepare($str);
        //assign
        $order_mem_id = $_POST['order_mem_id'];
        $order_name = $_POST['order_name'];
        $order_mail = $_POST['order_mail'];
        $order_store_id = $_POST['order_store_id'];
        $order_store_name = $_POST['order_store_name'];
        $order_phone = $_POST['order_phone'];
        $order_tele = $_POST['order_tele'];
        $order_size = $_POST['order_size'];
        $order_time_arrive = $_POST['order_time_arrive'];
        $order_time_get = $_POST['order_time_get'];
        // $order_pic         = $_POST['order_pic'];
        $order_memo = $_POST['order_memo'];
        //bindParam
        $stmt->bindParam(':order_mem_id', $order_mem_id);
        $stmt->bindParam(':order_name', $order_name);
        $stmt->bindParam(':order_mail', $order_mail);
        $stmt->bindParam(':order_store_id', $order_store_id);
        $stmt->bindParam(':order_store_name', $order_store_name);
        $stmt->bindParam(':order_phone', $order_phone);
        $stmt->bindParam(':order_tele', $order_tele);
        $stmt->bindParam(':order_size', $order_size);
        $stmt->bindParam(':order_time_arrive', $order_time_arrive);
        $stmt->bindParam(':order_time_get', $order_time_get);
        // $stmt -> bindParam( ':order_pic'   , $order_pic );
        $stmt->bindParam(':order_memo', $order_memo);

        //execute
        $stmt->execute();
        $order_id = $conn->lastInsertId();
        $_SESSION['order_id'] = $order_id;
        echo $order_id;
    }

    //?????????????????????................................................................
    if (isset($_FILES['order_pic'])) {
        echo 'order_id: ' . $_POST['order_id'];
        $order_id = $_POST['order_id'];
        //????????????????????????==================================================
        $file = $_FILES['order_pic'];

        //??????&???????????????====================================================
        $max_size = 4096 * 4096; //(1)????????????
        $allow_ext = array('jpeg', 'jpg', 'png', 'gif'); //(2)????????????

        $path = 'ref/order_pic/'; //(3)????????????
        if (!file_exists($path)) {mkdir($path);}

        $file_name = $file['name'];
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_basename = 'order_' . $order_id;
        $file_name = $file_basename . '.' . $ext; //(4)????????????

        //??????fn????????????=================================================================
        include_once 'shared/fn_upload_chk.php';
        $result = fn_upload_chk($file, $max_size, $allow_ext, $path, $file_name, true);

        if ($result == 1) {

            //???????????????????????????, ????????????????????????, ?????????????????????==============================
            if (file_exists($path . $file_name)) {

                //??????(1)-----------------------------------
                $smallfilename = $file_basename . '_s.' . $ext; //??????????????????

                //??????????????????
                $dst_w = 600;
                $dst_h = 600;

                include_once 'shared/fn_thumbnail.php';
                $src_name = $path . $file_name;
                fn_thumbnail($src_name, $path, $smallfilename, $dst_w, $dst_h);

                //??????????????????????????????
                $order_pic = $smallfilename;

                //??????(2)-----------------------------------
                $smallfilename = $file_basename . '_s.' . $ext; //??????????????????

                //??????????????????
                $dst_w = 600;
                $dst_h = 600;

                fn_thumbnail($src_name, $path, $smallfilename, $dst_w, $dst_h, true);

                //??????????????????????????????
                $smallfilename = $file_basename . '_s.' . $ext;

                // //?????????????????????
                try {
                    //~~~~~~??????????????????~~~~~~~~
                    //??????SQL??????>??????????????????=========================
                    $sql_str = "UPDATE orderlist SET order_pic   = :order_pic
                        WHERE order_id = :order_id";
                    $stmt = $conn->prepare($sql_str);

                    //????????????===========================================
                    $order_id = $_POST['order_id'];
                    //????????????===========================================
                    echo $smallfilename;
                    $stmt->bindParam(':order_pic', $smallfilename);
                    $stmt->bindParam(':order_id', $order_id);

                    //??????==============================================
                    $stmt->execute();
                    header('Location: ?page=orderfinish');
                } catch (PDOException $e) {
                    die("Errpr!: " . $e->getMessage());
                }

            } else {
                echo '????????????:' . $result; //???????????????
            }
        } else {
            $_SESSION['upload_msg'] = $result;
        }
        header('Location: ?page=orderfinish');
    }

} catch (PDOException $e) {
    die("Error!: " . $e->getMessage());
}
