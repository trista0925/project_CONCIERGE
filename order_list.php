<?php
require_once 'shared/conn_PDO.php';
session_start();
if (!isset($_SESSION['mem_id']) || $_SESSION['mem_id'] == '') {
    header('Location: index.php?msg=2');
}

$mem_mail = $_SESSION['mem_mail'];
try {
    /* [ pagenation ] */
    $max_rows = 5; //一頁最多筆數
    $curr_page = 0; //目前第幾頁(索引號碼)
    if (isset($_GET['curr_page'])) {$curr_page = $_GET['curr_page'];}

    $first_row = $curr_page * $max_rows; //目前頁面第一筆的索引號碼
    $last_row = $first_row + $max_rows - 1; //目前頁面最後一筆的索引號碼
    $total_rows = 0; //總共的筆數
    $total_pages = 0; //總共的頁數
    $page_file = 'admin_news'; //連結的頁面
    /* [ $where ] */
    $where = '';

    /* [ orderlist ] */
    $sql_str = "SELECT * FROM orderlist $where";
    $RS_orderlist_all = $conn->query($sql_str);
    $total_rows = $RS_orderlist_all->rowCount(); //總筆數
    $total_pages = ceil($total_rows / $max_rows); //總頁數

    $sql_str = "SELECT orderlist.*
  FROM orderlist
  $where
  ORDER BY orderlist.order_time_buy DESC
  LIMIT $first_row, $max_rows";
    $RS_orderlist = $conn->query($sql_str);
    $order_list = array();

    foreach ($RS_orderlist as $key => $item) {
        // $order_list[$key] = $item;
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
    // var_dump($RS_orderlist);
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
  <title>行動管理員後台 CONCIERGE｜會員訂單管理</title>
  <link rel="icon" href="LOGO/Concierge_icon.ico">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link href="css/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/index.css" rel="stylesheet">
</head>

<body>
  <section class="container-fluid no-any-pd">
    <!--左側menu區塊-->
    <div class="row">
      <div class="col-lg-4 order-lg-1 order-2 order-list-left">
        <div class="order-list-menu">
        <img src="LOGO/Concierge_1_white.svg" class="img-fluid p-3 my-2">
        <a href="order_list.php"><img src="images/Concierge_order_list.png" class="img-fluid my-2"></a>
        <a href="store_list.php"><img src="images/Concierge_order_list01.png" class="img-fluid my-2"></a>
        </div>
      </div>
      <!--"右側會員訂單管理內容區塊-->
      <div class="col-lg-7 order-lg-2 order-1 order-list-right">
        <h1>會員訂單管理</h1>
        <!--"管理者"（登入身份）須由後端帶入-->
        <div class="order-list-head">
        <span>管理者：<?php if ($mem_mail) {echo $mem_mail;}?></span>
        <a href="member_logout.php" class="logout-submit">登出</a>
        </div>
        <!--訂單顯示table區-->
        <table class="table table-striped">
            <thead class="table-primary"> 
              <th>訂單編號</th>
              <th>會員姓名</th>
              <th colspan="2">取件店家名稱</th>
            </thead>
            <tbody>
              <?php foreach ($order_list as $key => $item) {?>
                <tr>
                  <td><?php echo $item['order_id'] ?></td>
                  <td><?php echo $item['order_name'] ?></td>
                  <td><?php echo $item['order_store_name'] ?></td>
                  <td><div class="order-btn"><a href="javascript:;" type="submit" name="back" value="訂單內容" onclick="orderModal('<?php echo $key ?>')">訂單內容</a></div></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
        <!-- pagenation -->
        <div class="pagenumber">
          <ul class="pager pagination">
            <?php if ($curr_page > 0) {
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
            <a href="member_index.php" type="submit" name="back" value="回上一頁">回上一頁</a>
          </div>
        </div>
      </div>
    </div>
  </section>
    <!-- 隱藏區塊訂單內容 -->
    <div class="mask">
      <div class="btn-mask">
        <i class="fa fa-times fa-2x" aria-hidden="true"></i>
        <div class="mask-content pt-lg-5 pb-lg-2 pt-3">
            <h1>訂單編號【<span class="order-id"></span>】</h1>
        </div>
        <div class="row justify-content-center">
          <div class="col-lg-4">
            <p>填單時間：</p><span class="order-time-buy"></span>
            <br>
            <p>會員姓名：</p><span class="order-name"></span>
            <br>
            <p>市話：</p><span class="order-tele"></span>
            <br>
            <p>手機：</p><span class="order-phone"></span>
            <br>
            <p>Email：</p><span class="order-mail"></span>
            <br>
            <p>商品大小：</p><span class="order-size"></span>
            <br>
            <p>備註：</p><span class="order-memo"></span>
          </div>
          <div class="col-lg-4">     
            <p>取件店家代號：</p><span class="order-store-id"></span>
            <br>
            <p>取件店家名稱：</p><span class="order-store-name"></span>
            <br>   
            <p>抵達店家時間：</p><span class="order-time-arrive"></span>
            <br>
            <p>預計取件時間：</p><span class="order-time-get"></span>
            <br>
            <div><p>購物證明</p></div>
            <img class="order-pic" src="">
          </div>
        </div>
      </div>
    </div>
  <script src="js/jquery-3.5.1.min.js"></script>
  <script>
    var RT = {}
    RT.content = <?php echo json_encode($order_list); ?> || {}
console.log(RT.content)
</script>
<script>
  function orderModal(id) {
    var setClass = 'order',
        elData = ['id', 'name', 'mail', 'tele', 'phone', 'store-id',
        'store-name', 'size', 'time-buy', 'time-get', 'time-arrive',
        'memo'],
        sqlFld = elData.map((d,i)=>d.replace(/\-/g,"_"));
    var picUrl = `ref/order_pic/${RT.content[id]['order_pic']}.jpg`
    elData.forEach((v,k) => {
      $(''+`.${setClass}-${elData[k]}`+'').text(
        RT.content[id][''+`${setClass}_${sqlFld[k]}`+'']);
    })
    $('.order-pic').attr('src', picUrl)
  }
</script>
<script>
  $(".table a").click(function() {
    var href = $(this).attr("href");
    $('.btn-mask').fadeIn(1000);
    $('.mask').fadeIn(500);
  });

  $('.mask,.fa-times').click(function() {
    $('.btn-mask,.mask').fadeOut(500);
  });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>