<?php
/*
** $src_name   原圖檔名(含路徑)
** $dst_name   縮圖名稱
** $path       縮圖存放路徑
** $dst_w      縮圖寬度
** $dst_h      縮圖高度
** $del_source 是否刪除來源圖檔
*/
function fn_thumbnail($src_name, $path, $dst_name, $dst_w, $dst_h, $del_source=false) {

  //運用getimagesize()取得圖像尺寸資訊====================================
  $imgfileInfo = @getimagesize($src_name);

  //也可以運用這個函式測試檔案是不是圖像，不是圖像回傳false
  //if (!$imgfileInfo) { exit('<br>文件不是圖片類型'); }

  print_r($imgfileInfo);
  //[0] => 圖像寬度
  //[1] => 圖像高度
  //[2] => 圖像類型(1:GIF, 2:JPG, 3:PNG....)
  //[3] => 寬度和高度的字串，可以直接用於HTML的<image>標籤
  //第5個資訊bits => 顏色位元
  //第6個資訊channels => 色版數, RGB為3
  //第7個資訊mime => 此信息為HTTP檔頭資訊中發送宣告用，例如：header（“Content-type：image / jpeg”）;


  //設定一個list變數清單, 分別記錄陣列中逐項的資訊內容==============================
  //如下, $src_w變數記錄$imgfileInfo[0], $src_h變數記錄$imgfileInfo[1]
  list($src_w, $src_h, $src_ext) = $imgfileInfo;


  //決定縮圖大小==================================================================
  //計算來源的寬高比例, 再重新計算原圖依比例縮小的尺寸
  $ratio_orig = $src_w / $src_h;

  //如果目標的寬高比例>來源的寬高比例, 表示目標定義過寬, 否則表示目標定義過高
  if ($dst_w / $dst_h > $ratio_orig) {
    $dst_w = $dst_h * $ratio_orig;      //以高度為基礎算出寬度
  } else {
    $dst_h = $dst_w / $ratio_orig;      //以寬度為基礎算出高度
  }


  //準備影像 imagecreatefromjpeg(完整檔名) 返回一個來源圖像=========================
  //$src_image = imagecreatefromjpeg($path.$dst_name);

  //準備影像 imagecreatefromjpeg(完整檔名) 返回一個來源圖像================
  switch ( $src_ext ) {
    case 1:    $src_image = imagecreatefromgif($src_name);   break;
    case 2:    $src_image = imagecreatefromjpeg($src_name);  break;
    case 3:    $src_image = imagecreatefrompng($src_name);   break;
  }


  //創建畫布 imagecreatetruecolor(寬度, 高度)======================================
  $dst_image = imagecreatetruecolor($dst_w, $dst_h);

  // 透明背景
  // imagealphablending(目標圖檔, 是否保持透明);
  imagesavealpha($dst_image, true);
  // 為一幅圖像分配含alpha透明的顏色 
  // imagecolorallocatealpha(目標圖檔, red, green, blue, alpha)
  // alpha 的值 0 ~ 127, 0表示完全不透明, 127表示完全透明
  $color = imagecolorallocatealpha($dst_image, 0, 0, 0, 127);
  // 在指定image圖像的自座標x，y（圖像左上角 0, 0）處用 color 顏色執行區域填滿
  imagefill($dst_image, 0, 0, $color);




  //重新採樣拷貝部分圖像並調整大小===================================================
  //imagecopyresampled ( resource $dst_image , resource $src_image , 
  //                     int $dst_x , int $dst_y , int $src_x , int $src_y , 
  //                     int $dst_w , int $dst_h , int $src_w , int $src_h ) : bool

  //imagecopyresampled ( 目標圖像 , 來源圖像 , 
  //                     目標X座標 , 目標y座標 , 來源x , 來源y , 
  //                     目標w , 目標h , 來源w , 來源h )

  //將一幅圖像中的一塊正方形區域拷貝到另一個圖像中，平滑地插入像素值，
  //因此，尤其是，減小了圖像的大小而仍然保持了極大的清晰度。

  //換句話說，imagecopyresampled（）將採取的矩形區域從
  //來源 src_image 寬度 src_w 高度 src_h 在位置（ src_x ， src_y ），
  //並將其放置在一個矩形區域
  //目標 dst_image 寬度 dst_w 高度 dst_h 在位置（ dst_x ， dst_y ）。

  //如果來源和目標的寬度和高度不同，則會進行相應的圖像收縮和拉伸。坐標指的是左上角。

  imagecopyresampled($dst_image, $src_image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);

  //輸出圖像到指定位置指定檔名============================================================
  //imagejpeg($dst_image, $path.$smallfilename);

  //輸出圖像到指定位置指定檔名======================================
  switch ( $src_ext ) {
    case 1:  imagegif($dst_image, $path.$dst_name);   break;
    case 2:  imagejpeg($dst_image, $path.$dst_name);  break;
    case 3:  imagepng($dst_image, $path.$dst_name);   break;
  }

  //是否要刪除原上傳的檔案===============================================
  if( $del_source ){
    unlink($src_name);
  }  
  
  //釋放刪除主機端暫存的圖像==============================================================
  imagedestroy($src_image);
  imagedestroy($dst_image);

}

?>