<?php
require_once 'shared/conn_PDO.php';
session_start();
if (!isset($_SESSION['mem_id']) || $_SESSION['mem_id'] == '') {
    header('Location: ?page=mem_index');
}

$mem_mail = $_SESSION['mem_mail'];
//main
try {
    /* [ pagenation ] */
    $max_rows = 5; //一頁最多筆數
    $curr_page = 0; //目前第幾頁(索引號碼)
    if (isset($_GET['curr_page'])) {$curr_page = $_GET['curr_page'];}

    $first_row = $curr_page * $max_rows; //目前頁面第一筆的索引號碼
    $last_row = $first_row + $max_rows - 1; //目前頁面最後一筆的索引號碼
    $total_rows = 0; //總共的筆數
    $total_pages = 0; //總共的頁數
    $page_file = 'store_list&admin_news'; //連結的頁面
    /* [ $where ] */
    $where = '';

    /* [ store_list content ] */
    $sql_str = "SELECT * FROM store $where";
    $RS_orderlist_all = $conn->query($sql_str);
    $total_rows = $RS_orderlist_all->rowCount(); //總筆數
    $total_pages = ceil($total_rows / $max_rows); //總頁數

    $sql_str = "SELECT store.*
  FROM store
  $where
  ORDER BY store.store_id DESC
  LIMIT $first_row, $max_rows";
    $RS_storelist = $conn->query($sql_str);
    $store_list = array();
    foreach ($RS_storelist as $key => $item) {
        $store_list[$key]['store_id'] = $item['store_id'];
        $store_list[$key]['store_name'] = $item['store_name'];
        $store_list[$key]['store_area_id'] = $item['store_area_id'];
        $store_list[$key]['store_phone'] = $item['store_phone'];
        $store_list[$key]['store_address'] = $item['store_address'];
        $store_list[$key]['store_time_open'] = $item['store_time_open'];
        $store_list[$key]['store_memo'] = $item['store_memo'];
    }
    // var_dump($store_list);

    /* [ area_list content ] */
    $str = "SELECT area.* FROM area ORDER BY area.area_id ASC";
    $RS_area = $conn->query($str);
    $area_list = array();
    foreach ($RS_area as $key => $item) {
        $area_list[$item['area_id']] = $item['area_name'];
    }

    /* [ rt_content ] */
    $rt_content = array(
        'areaList' => $area_list,
        'storeList' => $store_list,
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
  <title>行動管理員後台 CONCIERGE｜店家管理</title>
  <link rel="icon" href="./images/logo/Concierge_icon.ico">
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
        <a href="./"> <img src="images/logo/Concierge_1_white.svg" class="img-fluid p-3 my-2"></a>
        <a href="?page=order_list"><img src="images/Concierge_order_list.png" class="img-fluid my-2"></a>
        <a href="?page=store_list"><img src="images/Concierge_order_list01.png" class="img-fluid my-2"></a>
        </div>
      </div>
      <!--"右側會員訂單管理內容區塊-->
      <div class="col-lg-7 order-lg-2 order-1 order-list-right">
        <div class="order-list-head">
          <h1>店家管理</h1>
          <!--"管理者"（登入身份）須由後端帶入-->
          <div class="order-list-admin">
          <span>管理者：<?php if ($mem_mail) {echo $mem_mail;}?></span>
          <a href="?page=member_logout" class="logout-submit">登出</a>
          </div>
        </div>
      <!--訂單顯示table區-->
      <table class="table table-striped">
          <thead class="table-primary">
            <th>店家編號</th>
            <th>店家名稱</th>
            <th>地區分類</th>
            <th width="30%"><div class="add-btn"><a href="btn-mask" data-target="btn-mask" type="submit">新增店家</a></div></th>
          </thead>
          <tbody>
            <?php foreach ($store_list as $key => $item) {?>
            <tr>
              <td><?php echo $item['store_id'] ?></td>
              <td><?php echo $item['store_name'] ?></td>
              <td><?php echo $area_list[$item['store_area_id']] ?></td>
              <td width="30%">
              <div class="look-btn"><a href="javascript:;" type="submit" onclick="addModal('<?php echo $key ?>')">查看</a></div>
              <div class="edit-btn"><a href="javascript:;" type="submit" onclick="editModal('<?php echo $key ?>')">編輯</a></div>
              <div class="delete-btn"><a href="javascript:;" type="submit" onclick="delStore('<?php echo $key ?>')">刪除</a></div>
              </td>
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
         <div class="order-btn pt-4">
            <a href="?page=member_index" type="submit" name="back" value="回上一頁">回上一頁</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="mask">
    <!-- 隱藏區塊-新增 -->
    <div class="add-mask">
      <i class="fa fa-times fa-2x" aria-hidden="true"></i>
      <div class="mask-content pt-lg-5 pb-lg-4 pt-3">
        <h1>【新增】店家資訊</h1>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-4">
          <p>店家名稱</p><input type="text" name="store_name" id="store_name" class="form-control add-store-name" value="" placeholder="輸入店家名稱" required>
          <p>店家電話</p><input type="text" name="store_phone" class="form-control store-phone" id="store_phone" value="" placeholder="輸入店家電話號碼" required>
          <p>店家營業時間</p><input type="text" name="store_time_open" class="form-control add-store-time-open" id="store_time_open" value="" placeholder="填入店家營業時間" required>
        </div>
        <div class="col-lg-4">
          <p>店家地區分類</p><select name="store_area_id" class="form-control add-store-area-id" required></select>
          <p>店家地址</p><input type="text" name="store_address" class="form-control add-store-address" id="store_address" value="" placeholder="輸入店家地址" required>
          <p>備註</p><input type="text" name="store_memo" class="form-control add-store-memo" id="store_memo" value="" placeholder="內容">
        </div>
      </div>
      <div class="row justify-content-center pt-4">
        <input type="button" id="submit_add" class="submit" onclick="" value="新增店家">
      </div>
    </div>
    <!-- 隱藏區塊-查看 -->
    <div class="check-mask">
      <i class="fa fa-times fa-2x" aria-hidden="true"></i>
      <div class="mask-content pt-lg-5 pb-lg-3 pt-3">
        <h1>【查看】店家資訊</h1>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <p>店家編號：</p><span class="query-store-id"></span>
          <br>
          <p>店家名稱：</p><span class="query-store-name"></span>
          <br>
          <p>店家電話：</p><span class="query-store-phone"></span>
          <br>
          <p>店家地址：</p><span  class="query-store-address"></span>
          <br>
          <p>店家營業時間：</p><span class="query-store-time-open"></span>
          <br>
          <p>備註：</p><span class="query-store-memo"></span>
        </div>
      </div>
    </div>
    <!-- 隱藏區塊-編輯 -->
    <div class="edit-mask">
      <i class="fa fa-times fa-2x" aria-hidden="true"></i>
      <div class="mask-content pt-lg-5 pb-lg-4 pt-3">
        <h1>【編輯】店家資訊</h1>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-4">
          <p>店家名稱 編號：<span class="edit-store-id"></p><input type="text" name="store_name" class="form-control edit-store-name" value="" placeholder="輸入店家名稱" required>
          <p>店家電話</p><input type="text" name="store_number" class="form-control edit-store-phone" value="" placeholder="輸入店家電話號碼" required>
          <p>店家營業時間</p><input type="text" name="store_time" class="form-control edit-store-time-open" value="" placeholder="填入店家營業時間" required>
        </div>
        <div class="col-lg-4">
          <p>店家地區分類</p><select name="store_area_id" class="form-control edit-store-area-id store_Area" required></select>
          <p>店家地址</p><input type="text" name="store_address" class="form-control edit-store-address" value="" placeholder="輸入店家地址" required>
          <p>備註</p><input type="text" name="store_note" class="form-control edit-store-memo" value="" placeholder="內容" required>
        </div>
        </div>
        <div class="row justify-content-center pt-4">
        <input type="submit" id="submit_eidt" class="submit" value="編輯完成">
        </div>
      </div>
    </div>
    <!-- 隱藏區塊-刪除 -->
    <div class="del-mask">
    <i class="fa fa-times fa-2x" aria-hidden="true"></i>
      <div class="mask-content pt-lg-5 pb-lg-2 pt-3">
        <h3>是否要刪除此筆店家資料</h3>
      </div>
      <div class="row justify-content-center">
        <div class="del-y-btn"><a href="javascript:;" id="submit_del" type="submit">是</a></div>
        <div class="del-n-btn"><a href="javascript:;" type="submit">否</a></div>
      </div>
    </div>
  </section>
<script src="js/jquery-3.5.1.min.js"></script>
<script>
  const storeDataName = ['id', 'name', 'mail', 'phone', 'area-id', 'address', 'time-open', 'memo'];
  const storeSQLName = storeDataName.map((d,i)=>d.replace(/\-/g,"_"));
  const thisUrl = RT.content['PHP_SELF']+'?'+RT.content['QUERY_STRING']
  // console.log(thisUrl)

  /* [query] */
  function addModal(id) {
    // console.log(id)
    var setClass = 'store',
      functionClass = 'query',
      elData = storeDataName,
      sqlFld = storeSQLName;
      elData.forEach((v,k) => {
      $(''+`.${functionClass}-${setClass}-${elData[k]}`+'').text(
        RT.content['storeList'][id][''+`${setClass}_${sqlFld[k]}`+'']);
    })
    $('.add-store-area-id').text(RT.content['areaList'][RT.content['storeList'][id]['store_area_id']])
  }

  /* [edit] */
  function editModal(id) {
    // console.log(id)
    var setClass = 'store',
      functionClass = 'edit',
      elData = storeDataName,
      sqlFld = storeSQLName;

    areaSelect('edit-store-area-id', RT.content.areaList, RT.content['storeList'][id]['store_area_id'])
    elData.forEach((v,k) => {
      $(''+`.${functionClass}-${setClass}-${elData[k]}`+'').val(
        RT.content['storeList'][id][''+`${setClass}_${sqlFld[k]}`+'']);
    })
    $('.edit-store-id').text(RT.content['storeList'][id]['store_id'])
  }

  /* [del] */
  function delStore(id) {
    // console.log("del"+id)
    var storeId = RT.content['storeList'][id]['store_id']
    $('#submit_del').attr('data-del-store-id', storeId)
    $('#submit_del').attr('data-id', id)
    // console.log('storeId'+storeId)
  }

  /* [render area select] */
  function areaSelect(elClass, selectData, selecledVal) {
    // console.log((selecledVal))
    var $el = $('.'+elClass)
    var isSelected = (selecledVal == 0)? 'selected' : ''
    var areaTemplate = `<option value="0" ${isSelected}>請選擇商店所在區域</option>`

    Object.values(selectData).forEach((v,k) => {
      isSelected = (selecledVal == (k+1))? 'selected' : ''
      areaTemplate += `<option value="${k+1}" data-value="${k+1}"  ${isSelected}>${v}</option>`
    })
    $el.append(areaTemplate)
  }

  /* [clear area select] */
  function clearAreaSelect(elClass) {
    $('.'+elClass).html('')
  }
  $(document).ready(function() {
    areaSelect('add-store-area-id', RT.content.areaList, 0)
    /* [add] */
    //submit add
    $('#submit_add').click(function() {
      var addData = {}
    addData['process']        = 'insert'
    addData['store_name']     = $('.add-store-name').val()
    addData['store_area_id']  = $('.add-store-area-id').val()
    addData['store_phone']    = $('.store-phone').val()
    addData['store_address']  = $('.add-store-address').val()
    addData['store_time_open'] = $('.add-store-time-open').val()
    addData['store_memo']     = $('.add-store-memo').val()
    addData['this_url'] = thisUrl
    console.log(addData)
    $.post({
      url: '?page=store_process',
      data: addData,
      crossDomain: true,
    }).done(function(res) {
      console.log("res"+res)
    })
    .fail(function(XMLHttpRequest, textStatus, errorThrown) {
      console.log('XMLHttpRequest:'+XMLHttpRequest)
      console.log('status:'+XMLHttpRequest.status)
      console.log('readyState:'+XMLHttpRequest.readyState)
      console.log('status:'+textStatus)
    })
    location.href = thisUrl
  })

  //submit-eidt
  $('#submit_eidt').click(function() {
    var addData = {}
    addData['process']        = 'update'
    addData['store_id']       = $('.edit-store-id').val()
    addData['store_name']     = $('.edit-store-name').val()
    addData['store_area_id']  = $('.edit-store-area-id').val()
    addData['store_phone']    = $('.edit-store-phone').val()
    addData['store_address']  = $('.edit-store-address').val()
    addData['store_time_open'] = $('.edit-store-time-open').val()
    addData['store_memo']     = $('.edit-store-memo').val()
    addData['this_url'] = thisUrl
    console.log(addData)
    $.post({
      url: '?page=store_process',
      data: addData,
      crossDomain: true,
    }).done(function(res) {
      // console.log("res"+res)
    })
    .fail(function(XMLHttpRequest, textStatus, errorThrown) {
      console.log('XMLHttpRequest:'+XMLHttpRequest)
      console.log('status:'+XMLHttpRequest.status)
      console.log('readyState:'+XMLHttpRequest.readyState)
      console.log('status:'+textStatus)
    })
    location.href = thisUrl
  })

  //submit-del
  $('#submit_del').click(function() {
    var itemId = $('#submit_del').attr('data-id')
    var addData = {}
    addData['process']  = 'delete'
    addData['store_id'] = RT.content['storeList'][itemId]['store_id']
    addData['this_url'] = thisUrl
    // console.log(addData)
    $.post({
      url: '?page=store_process',
      data: addData,
      crossDomain: true,
    }).done(function(res) {
      console.log("res"+res)
    })
    .fail(function(XMLHttpRequest, textStatus, errorThrown) {
      console.log('XMLHttpRequest:'+XMLHttpRequest)
      console.log('status:'+XMLHttpRequest.status)
      console.log('readyState:'+XMLHttpRequest.readyState)
      console.log('status:'+textStatus)
    })
    location.href = thisUrl
  })
})
</script>
<script>
  //新增
  $(".table .add-btn").click(function(e) {
    e.preventDefault();
    var href = $(this).attr("href");
    $('.add-mask').fadeIn(1000);
    $('.mask').fadeIn(500);
  });
  $('.fa-times').click(function() {
    $('.add-mask,.mask').fadeOut(500);
  });

  //查看
  $(".table .look-btn").click(function(e) {
    e.preventDefault();
    var href = $(this).attr("href");
    $('.check-mask').fadeIn(1000)
    $('.mask').fadeIn(500);
  });
  $('.fa-times').click(function() {
    $('.check-mask,.mask').fadeOut(500);
  });

  //編輯
  $(".table .edit-btn").click(function(e) {
    e.preventDefault();
    var href = $(this).attr("href");
    $('.edit-mask').fadeIn(1000);
    $('.mask').fadeIn(500);
  });
  $('.fa-times').click(function() {
    clearAreaSelect('edit-store-area-id')
    $('.edit-mask,.mask').fadeOut(500);
  });

  //刪除
  $(".delete-btn").click(function(e) {
    e.preventDefault();
    var href = $(this).attr("href");
    $('.del-mask').fadeIn(1000);
    $('.mask').fadeIn(500);
  });
  $('.fa-times ,.del-n-btn').click(function() {
    $('.del-mask,.mask').fadeOut(500);
  });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>
