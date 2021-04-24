<?php
require_once 'shared/conn_PDO.php';
session_start();
if (!isset($_SESSION['mem_id']) || $_SESSION['mem_id'] == '') {
    header('Location: index.php?msg=2');
}

$mem_mail = $_SESSION['mem_mail'];
try {
    /* [ pagenation ] */
    $max_rows = 8; //一頁最多筆數
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
  <link href="css/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/order_index.css" rel="stylesheet">
</head>

<body>
  <section class="container">
    <!--左側menu區塊-->
    <div class="menu">
      <p id="logo"><img src="LOGO/Concierge_1_white.svg"></p>
      <p id="order_list"><a href="order_list.php"><img src="images/Concierge_order_list.png"></a></p>
      <p id="order_list"><a href="store_list.php"><img src="images/Concierge_order_list01.png"></a></p>
    </div>
    <!--"右側會員訂單管理內容區塊-->
    <div class="content">
      <div class="wrap">
        <h3 class="text-center">會員訂單管理</h3>
        <!--"管理者"（登入身份）須由後端帶入-->
        <span>
          <span>管理者: <?php if ($mem_mail) {echo $mem_mail;}?></span>
          /<a href="mem_logout.php">登出</a>
        </span>
      </div>
      <hr>
      <!--訂單顯示table區-->
      <div class="table">
        <table>
          <thead>
            <th>訂單編號</th>
            <th>會員姓名</th>
            <th>預計抵達時間</th>
            <th>預計取件時間</th>
            <th>取件店家名稱</th>
            <th>&nbsp;&nbsp;&nbsp;</th>
          </thead>
          <tbody>
            <?php echo $order_list ?>
            <?php foreach ($order_list as $key => $item) {?>
            <tr>
              <td><?php echo $item['order_id'] ?></td>
              <td><?php echo $item['order_name'] ?></td>
              <td><?php echo $item['order_time_arrive'] ?></td>
              <td><?php echo $item['order_time_get'] ?></td>
              <td><?php echo $item['order_store_name'] ?></td>
              <td><a href="javascript:;" onclick="orderModal('<?php echo $key ?>')"><img src="images/orderlist_editbtn.png"></a></td>
            </tr>
            <?php }?>
          </tbody>
        </table>
      </div>

      <!-- pagenation -->
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
}
?>
        </ul>
      </div>
    </div>

    <!--隱藏區塊“訂單內容”-->
    <div class="Mask" id="Mask">
      <div class="btnMask" id="btnMask">
        <i class="fa fa-times fa-4x" aria-hidden="true"></i>
        <div class="Mask_content">
          <div class="mask_title">
            <h5>訂單編號</h5>
            <p><span class="order-id"></span></p>
          </div>
          <div class="mask_info">
            <div class="table_left">
              <tr>
                <th>會員姓名</th>
                <td><span class="order-name"></span></td>
              </tr>
              <br>
              <br>
              <tr>
                <th>電話</th>
                <td><span class="order-phone"></span></td>
              </tr>
              <br>
              <br>
              <tr>
                <th>Email</th>
                <td><span class="order-mail"></span></td>
              </tr>
            </div>
            <div class="table_right">
              <tr>
                <th>預計到貨時間</th>
                <td><span class="order-time-arrive"></span></td>
              </tr>
              <br>
              <br>
              <tr>
                <th>預計取件時間</th>
                <td><span class="order-time-get"></span></td>
              </tr>
              <br>
              <br>
            </div>
          </div>

          <!-- MASK -->
          <div class="mask_info2">
            <div class="table_left">
              <tr>
                <th>商品尺寸</th>
                <br>
                <td><span class="order-size"></span></td>
              </tr>
              <br>
              <br>
              <tr>
                <th>購買日期</th>
                <br>
                <td><span class="order-time-buy"></span></td>
              </tr>
              <br>
              <br>
              <tr>
                <th>購物證明</th>
                <br>
                <td><img class="order-pic" src="" height="300"></td>
              </tr>
            </div>
            <div class="table_right">
              <tr>
                <th>取件店家代號</th>
                <br>
                <td><span class="order-store-id"></span></td>
              </tr>
              <br>
              <br>
              <tr>
                <th>取件店家名稱</th>
                <br>
                <td><span class="order-store-name"></span></td>
              </tr>
              <br>
              <br>
              <tr>
                <th>備註</th>
                <br>
                <td>
                </td>
              </tr>
              <br>
              <br>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script src="js/jquery-3.5.1.min.js"></script>
  <script>
    var RT = {}
    RT.content = <?php echo json_encode($order_list); ?> || {}
console.log(RT.content)
</script>
<script>
  function orderModal(id) {
    var setClass = 'order',
        elData = ['id', 'name', 'mail', 'phone', 'store-id',
        'store-name', 'size', 'time-buy', 'time-get', 'time-arrive',
        'memo'],
        sqlFld = elData.map((d,i)=>d.replace(/\-/g,"_"));
    var picUrl = `../ref/order_pic/${RT.content[id]['order_pic']}`
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
    $('#btnMask').fadeIn(1000);
    $('#Mask').fadeIn(500);
  });

  $('#btnMask .fa-times').click(function() {
    $('#btnMask,#Mask').fadeOut(500);
  });
</script>
</body>
</html>