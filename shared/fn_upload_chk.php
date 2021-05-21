<?php
/*
 * $file        接收保存了上傳檔案的5個訊息
 * $max_size    設定允許上傳檔案容量的最大值
 * $allow_ext   設定允許上傳檔案的類型
 * $path        設定上傳檔案存放的位置
 * $file_name   設定上傳檔案的檔案名稱
 */

function fn_upload_chk($file, $max_size, $allow_ext, $path, $file_name)
{
    $error = $file['error']; //上傳工作傳回的錯誤訊息編號
    $file_size = $file['size']; //上傳檔案的檔案大小(容量)
    $tmp_name = $file['tmp_name']; //上傳到暫存空間的路徑/檔名
    //$file_name = $file['name'];          //上傳檔案的原來檔案名稱
    //$file_type = $file['type'];          //上傳檔案的類型(副檔名)
    $msg = ''; //負責回傳的訊息

    //(1)判斷上傳是否成功
    if ($error == 0) {

        //(2)判斷類型jpg,png,gif
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        if (!in_array($ext, $allow_ext)) {
            $allow_str = ''; //準備將允許檔案類型的陣列內容, 組合成字串
            foreach ($allow_ext as $key => $value) {
                //if的縮寫語法：條件?成立執行的工作:不成立執行的工作;
                $key == 0 ? $allow_str .= $value : $allow_str .= ', ' . $value;
            }
            if ($msg != '') {$msg .= '<br>';}
            $msg .= '檔案類型不符合，請選擇 ' . $allow_str . ' 檔案';
        }

        if ($msg == '') {
            //成功了~~~~
            move_uploaded_file($tmp_name, $path . $file_name);
            $msg = 1;
        }

    } else {
        //這裡表示上傳有錯誤, 匹配錯誤編號顯示對應的訊息
        switch ($error) {
            case 1:$msg = '上傳檔案超過 upload_max_filesize 容量最大值';
                break;
            case 2:$msg = '上傳檔案超過 post_max_size 總容量最大值';
                break;
            case 3:$msg = '檔案只有部份被上傳';
                break;
            case 4:$msg = '沒有檔案被上傳';
                break;
            case 6:$msg = '找不到主機端暫存檔案的目錄位置';
                break;
            case 7:$msg = '檔案寫入失敗';
                break;
            case 8:$msg = '上傳檔案被PHP程式中斷，表示主機端系統錯誤';
                break;
        }
    }

    return $msg;

}
