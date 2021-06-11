<?php
require_once 'shared/conn_PDO.php';
session_start();
if (!isset($_SESSION['mem_id']) || $_SESSION['mem_id'] == '') {
    header('Location: ?page=register');
}
/* [ mem_list content ] */
$mem_id = $_SESSION['mem_id'];
$mem_mail = $_SESSION['mem_mail'];
$mem_name = $_SESSION['mem_name'];
$mem_list = array(
    'mem_id' => $mem_id,
    'mem_mail' => $mem_mail,
    'mem_name' => $mem_name,
);

try {

    /* [ pagenation ] */
    $max_rows = 5; //一頁最多筆數
    $curr_page = 0; //目前第幾頁(索引號碼)
    if (isset($_GET['curr_page'])) {$curr_page = $_GET['curr_page'];}

    $first_row = $curr_page * $max_rows; //目前頁面第一筆的索引號碼
    $last_row = $first_row + $max_rows - 1; //目前頁面最後一筆的索引號碼
    $total_rows = 0; //總共的筆數
    $total_pages = 0; //總共的頁數
    $page_file = 'member_list&admin_news'; //連結的頁面
    /* [ $where ] */
    $where = '';

    /* [ orderlist ] */
    $sql_str = "SELECT orderlist.* FROM orderlist WHERE orderlist.order_mem_id = :mem_id";
    $stmt = $conn->prepare($sql_str);
    $stmt->bindParam(':mem_id', $mem_id);
    $stmt->execute();

    $fetch_all_rows = $stmt->fetchAll();
    $total_rows = count($fetch_all_rows); //總筆數
    $total_pages = ceil($total_rows / $max_rows); //總頁數

    $sql_str = "SELECT orderlist.*
  FROM orderlist
  WHERE orderlist.order_mem_id = :mem_id
  ORDER BY orderlist.order_time_buy DESC
  LIMIT $first_row, $max_rows";
    $stmt = $conn->prepare($sql_str);
    $stmt->bindParam(':mem_id', $mem_id);
    $stmt->execute();
    $fetch_all_orderlist = $stmt->fetchAll();

    $order_list = array();
    foreach ($fetch_all_orderlist as $key => $item) {
        $order_list[$key]['order_id'] = $item['order_id'];
        $order_list[$key]['order_mail'] = $item['order_mail'];
        $order_list[$key]['order_mem_id'] = $item['order_mem_id'];
        $order_list[$key]['order_memo'] = $item['order_memo'];
        $order_list[$key]['order_name'] = $item['order_name'];

        $order_list[$key]['order_phone'] = $item['order_phone'];
        $order_list[$key]['order_pic'] = $item['order_pic'];
        $order_list[$key]['order_size'] = $item['order_size'];
        $order_list[$key]['order_store_id'] = $item['order_store_id'];
        $order_list[$key]['order_store_name'] = $item['order_store_name'];

        $order_list[$key]['order_tele'] = $item['order_tele'];
        $order_list[$key]['order_time_arrive'] = $item['order_time_arrive'];
        $order_list[$key]['order_time_buy'] = $item['order_time_buy'];
        $order_list[$key]['order_time_get'] = $item['order_time_get'];
    }

    /* [ rt_content ] */
    $rt_content = array(
        'order_list' => $order_list,
        'mem_list' => $mem_list,
        'PHP_SELF' => $_SERVER['PHP_SELF'],
        'QUERY_STRING' => $_SERVER['QUERY_STRING'],
        'HTTP_HOST' => $_SERVER['HTTP_HOST'],
    );
} catch (PDOException $e) {
    die("Error!: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes, minimum-scale=1.0, maximum-scale=3.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta charset="UTF-8">
  <title>行動管理員 CONCIERGE｜訂單查詢</title>
  <link rel="icon" href="./images/logo/Concierge_icon.ico">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link href="css/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/index.css">
</head>
<body>
<section class="member-list container-fluid">
  <a href="./"><img src="images/logo/Concierge_1.svg" class="img-fluid"></a><h1>訂單查詢</h1>
      <div class="member-list-head">
     <!--"管理者"（登入身份）須由後端帶入-->
     <span>會員：<?php if ($mem_name) {echo $mem_name;}?></span>
     <span>帳號：<?php if ($mem_mail) {echo $mem_mail;}?></span>
     <a href="?page=member_logout" class="logout-submit" value="">登出</a>
      </div>
  </section>
  <section class="container no-any-pd">
    <!--訂單顯示table區-->
    <table class="table table-striped">
      <thead>
        <tr class="table-primary">
          <th>訂單編號</th>
          <th>取件人</th>
          <th>預計抵達時間</th>
          <th>預計取件時間</th>
          <th>取件店家名稱</th>
        </tr>
      </thead>
        <tbody>
          <?php foreach ($order_list as $key => $item) {?>
          <tr>
            <td scope="row col-6">
              <?php echo $item['order_id'] ?>
            </td>
            <td scope="row col-6">
            <?php echo $item['order_name'] ?>
            </td>
            <td scope="row">
            <?php echo $item['order_time_arrive'] ?>
            </td>
            <td scope="row">
            <?php echo $item['order_time_get'] ?>
            </td>
            <td scope="row">
            <?php echo $item['order_store_name'] ?>
            </td>
          </tr>
          <?php }?>
        </tbody>
      </table>
      <div class="pagenumber">
        <ul class="pager pagination">
          <?php
if ($curr_page > 0) {
    echo '<li><a href="?page=' . $page_file . '&curr_page=0"><i class="fa fa-angle-double-left"></i></a>';
    echo '<a href="?page=' . $page_file . '&curr_page=' . ($curr_page - 1) . '">
            <i class="fa fa-angle-left"></i></a></li>';
}
for ($i = 0; $i < $total_pages; $i++) {
    if ($i == $curr_page) {
        echo '<li><a href="javascript:;" class="current active">' . ($i + 1) . '</a></li>';
    } else {
        echo '<li><a href="?page=' . $page_file . '&curr_page=' . $i . '">';
        echo $i + 1;
        echo '</a></li>';
    } //if end
} //for end
if ($curr_page < $total_pages - 1) {
    echo '<li><a href="?page=' . $page_file . '&curr_page=' . ($curr_page + 1) . '">
            <i class="fa fa-angle-right"></i></a></li>';
    echo '<li><a href="?page=' . $page_file . '&curr_page=' . ($total_pages - 1) . '">
            <i class="fa fa-angle-double-right"></i></a></li>';
}?>
        </ul>
        <div class="order-btn pd-top pd-bottom">
        <a href="?page=member_index" type="submit" value="回上一頁">回上一頁</a>
      </div>
      </div>
  </section>
</body>
<script src="jquery-3.5.1.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script>
  RT = {}
  RT.content = <?php echo json_encode($rt_content) ?> || {}
  console.log(RT.content)
</script>
</html>
