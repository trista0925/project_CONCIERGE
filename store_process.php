<?php
// header('Content-Type: application/json; charset=UTF-8');
require_once('shared/conn_PDO.php');
session_start();

/* 新增 */
if ( isset($_POST['process']) && $_POST['process'] == 'insert' ) {

  try{ 
    $str = "INSERT INTO  store ( store_name, store_area_id, store_phone, store_address, store_time_open, store_memo )
                        VALUES ( :store_name, :store_area_id, :store_phone, :store_address, :store_time_open, :store_memo )";
    $stmt = $conn -> prepare($str);
    //assign
    $store_name       = $_POST['store_name'];
    $store_area_id    = $_POST['store_area_id'];
    $store_phone      = $_POST['store_phone'];
    $store_address    = $_POST['store_address'];
    $store_time_open  = $_POST['store_time_open'];
    $store_memo       = $_POST['store_memo'];
    $store_url        = $_POST['this_url'];
    //bindParam
    $stmt -> bindParam( ':store_name'      , $store_name );
    $stmt -> bindParam( ':store_area_id'   , $store_area_id );
    $stmt -> bindParam( ':store_phone'     , $store_phone );
    $stmt -> bindParam( ':store_address'   , $store_address );
    $stmt -> bindParam( ':store_time_open' , $store_time_open );
    $stmt -> bindParam( ':store_memo'      , $store_memo );

    //execute
    $stmt -> execute();
    echo $store_url;
  }
  catch ( PDOException $e ){
    die("Error!: ". $e->getMessage());
  }

}
/* 修改 */
if ( isset($_POST['process']) && $_POST['process'] == 'update' ) {

  try{ 
    $sql_str = "UPDATE store SET store_name = :store_name, 
                                store_area_id    = :store_area_id   , 
                                store_phone  = :store_phone , 
                                store_address    = :store_address   , 
                                store_time_open     = :store_time_open    , 
                                store_time_add  = :store_time_add,
                                store_memo   = :store_memo  
                          WHERE store_id       = :store_id";
    $stmt = $conn -> prepare($sql_str);
//date("Y-m-d");
    //assign
    $store_id         = $_POST['store_id'];
    $store_name       = $_POST['store_name'];
    $store_area_id    = $_POST['store_area_id'];
    $store_phone      = $_POST['store_phone'];
    $store_address    = $_POST['store_address'];
    $store_time_open  = $_POST['store_time_open'];
    $store_time_add   = date("Y-m-d G-i-s");
    $store_memo       = $_POST['store_memo'];
    $store_url        = $_POST['this_url'];
    //bindParam
    $stmt -> bindParam( ':store_id'      , $store_id );
    $stmt -> bindParam( ':store_name'      , $store_name );
    $stmt -> bindParam( ':store_area_id'   , $store_area_id );
    $stmt -> bindParam( ':store_phone'     , $store_phone );
    $stmt -> bindParam( ':store_address'   , $store_address );
    $stmt -> bindParam( ':store_time_open' , $store_time_open );
    $stmt -> bindParam( ':store_time_add'  , $store_time_add );
    $stmt -> bindParam( ':store_memo'      , $store_memo );

    //execute
    $stmt -> execute();
    echo $store_url;
  }
  catch ( PDOException $e ){
    die("Error!: ". $e->getMessage());
  }

}
/* 刪除 */
if ( isset($_POST['process']) && $_POST['process'] == 'delete' ) {
  try {
    $sql_str = "DELETE FROM store WHERE store_id = :store_id";
    $stmt = $conn -> prepare($sql_str);
    //assign
    $store_id         = $_POST['store_id'];
    $store_url        = $_POST['this_url'];
    //bindParam
    $stmt -> bindParam( ':store_id'        , $store_id );
    //execute
    $stmt -> execute();
    echo $store_url;
  }
  catch ( PDOException $e ){
    die("Error!: ". $e->getMessage());
  }
}
?>
