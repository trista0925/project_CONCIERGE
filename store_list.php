<?php 
require_once('shared/conn_PDO.php');
session_start();
if( !isset($_SESSION['mem_id']) || $_SESSION['mem_id'] == '' ){
  header('Location: index.php?msg=2');
}

$mem_mail = $_SESSION['mem_mail'];
//main
try {
  /* [ pagenation ] */
  $max_rows    = 8;                         //一頁最多筆數
  $curr_page   = 0;                         //目前第幾頁(索引號碼)
  if( isset( $_GET['curr_page'] ) ){ $curr_page = $_GET['curr_page']; }

  $first_row   = $curr_page * $max_rows;    //目前頁面第一筆的索引號碼
  $last_row    = $first_row + $max_rows-1;  //目前頁面最後一筆的索引號碼
  $total_rows  = 0;                         //總共的筆數
  $total_pages = 0;                         //總共的頁數
  $page_file   = 'admin_news';              //連結的頁面
  /* [ $where ] */
  $where = '';

  /* [ store_list content ] */
  $sql_str = "SELECT * FROM store $where";
  $RS_orderlist_all = $conn -> query($sql_str);
  $total_rows = $RS_orderlist_all->rowCount();          //總筆數
  $total_pages = ceil( $total_rows / $max_rows );       //總頁數

  $sql_str = "SELECT store.* 
  FROM store
  $where
  ORDER BY store.store_time_add DESC
  LIMIT $first_row, $max_rows";
  $RS_storelist = $conn -> query($sql_str);
  $store_list = array();
  foreach( $RS_storelist as $key => $item ) {
    $store_list[$key]['store_id']        = $item['store_id'];
    $store_list[$key]['store_name']      = $item['store_name'];
    $store_list[$key]['store_area_id']   = $item['store_area_id'];
    $store_list[$key]['store_phone']     = $item['store_phone'];
    $store_list[$key]['store_address']   = $item['store_address'];
    $store_list[$key]['store_time_open'] = $item['store_time_open'];
    $store_list[$key]['store_memo']      = $item['store_memo'];
  }
  // var_dump($store_list);
  
  /* [ area_list content ] */
  $str = "SELECT area.* FROM area ORDER BY area.area_id ASC";
  $RS_area = $conn -> query($str);
  $area_list = array();
  foreach( $RS_area as $key => $item ) {
    $area_list[$item['area_id']] = $item['area_name'];
  }

  /* [ rt_content ] */
  $rt_content = array(
    'areaList'   => $area_list,
    'storeList'  => $store_list,
    'PHP_SELF'  => $_SERVER['PHP_SELF'],
    'QUERY_STRING'  => $_SERVER['QUERY_STRING'],
    'HTTP_HOST'  => $_SERVER['HTTP_HOST'],
  );

}
catch ( PDOException $e ){
  die("Error!: ". $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes, minimum-scale=1.0, maximum-scale=3.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta charset="UTF-8">
  <title>行動管理員後台 CONCIERGE｜店家管理</title>
  <link rel="icon" href="LOGO/Concierge_icon.ico">
  <link href="css/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/store_list.css" rel="stylesheet">
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
        <h3>店家管理</h3>
        <!--"管理者"（登入身份）須由後端帶入-->
        <p></p><a href="mem_logout.php" value="">管理者 <?php if($mem_mail){  echo $mem_mail;}?>/登出</a>
      </div>
      <hr>
      <!--訂單顯示table區-->
      <div class="table">
        <table>
          <thead>
            <th>店家編號</th>
            <th>店家名稱</th>
            <th>店家地區分類</th>
            <th><a href="#btnMask1" data-target="#btnMask1"><img src="images/store_addnewbtn.png" width="25%" style="padding-left:150px;"></a></th>
          </thead>
          <tbody>
            <?php foreach( $store_list as $key => $item ){ ?>
            <tr>
              <td><?php echo $item['store_id']?></td>
              <td><?php echo $item['store_name']?></td>
              <td class="store-area"><?php echo $area_list[$item['store_area_id']] ?></td>
              <td>
                <a href="javascript:;" class="lookupbtn" onclick="addModal('<?php echo $key ?>')"><img src="images/store_lookupbtn.png"></a>
                <a href="javascript:;" class="editbtn" onclick="editModal('<?php echo $key ?>')"><img src="images/store_editbtn.png"></a>
                <a href="javascript:;" class="deletebtn" onclick="delStore('<?php echo $key ?>')"><img src="images/store_deletebtn.png"></a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <!-- pagenation -->
      <div class="pagenumber">
        <ul class="pager pagination">
          <?php
          if( $curr_page>0 ){
            echo '<li><a href="?page='.$page_file.'&curr_page=0"><i class="fa fa-angle-double-left"></i></a>';
            echo '<a href="?page='.$page_file.'&curr_page='.($curr_page-1).'">
                  <i class="fa fa-angle-left"></i></a></li>';
          }
          for( $i=0; $i<$total_pages; $i++ ){
            if( $i == $curr_page ){
              echo '<li><a href="javascript:;" class="current active">'.($i+1).'</a></li>';
            }else{
              echo '<li><a href="?page='.$page_file.'&curr_page='.$i.'">';
              echo $i+1;
              echo '</a></li>';
            } //if end
          } //for end
          if( $curr_page < $total_pages-1 ){
            echo '<li><a href="?page='.$page_file.'&curr_page='.($curr_page+1).'">
                  <i class="fa fa-angle-right"></i></a></li>';
            echo '<li><a href="?page='.$page_file.'&curr_page='.($total_pages-1).'">
                  <i class="fa fa-angle-double-right"></i></a></li>';
          }
          ?>
        </ul>
      </div>
    </div>



    <div class="Mask" id="Mask">
      <!--隱藏區塊“查看”-->
      <div class="btnMask" id="btnMask">
        <i class="fa fa-times fa-4x" aria-hidden="true"></i>
        <div class="Mask_content">
          <div class="mask_title">
            <h5>【查看】店家資訊</h5>
          </div>
          <div class="mask_info">
            <div class="table_left">
              <tr>
                <th>店家名稱</th>
                <td><span class="query-store-name"></span></td>
              </tr>
              <br>
              <br>
              <tr>
                <th>店家編號</th>
                <td><span class="query-store-id"></span></td>
              </tr>
              <br>
              <br>
              <tr>
                <th>店家地址</th>
                <td><span class="query-store-address"></span></td>
              </tr>
            </div>
            <div class="table_right">
              <tr>
                <th>店家電話</th>
                <td><span class="query-store-phone"></span></td>
              </tr>
              <br>
              <br>
            </div>
          </div>
          <div class="mask_info2">
            <div class="table_left">
              <tr>
                <th>店家地區分類</th>
                <br>
                <td>台北市&nbsp;<span class="query-store-area-id"></span></td>
              </tr>
              <br>
              <br>
              <tr>
                <th>備註</th>
                <br>
                <td><span class="query-store-memo"></span></td>
              </tr>
              <br>
              <br>
            </div>
            <div class="table_right">
              <tr>
                <th>店家營業時間</th>
                <br>
                <td><span class="query-store-time-open"></span></td>
              </tr>
              <br>
              <br>
            </div>
          </div>
        </div>
      </div>

      <!--隱藏區塊“新增店家”-->
      <div class="btnMask1" id="btnMask1">
        <i class="fa fa-times fa-4x" aria-hidden="true"></i>
        <form>
          <div class="Mask_content">
            <div class="mask_title">
              <h5>【新增】店家資訊</h5>

            </div>
            <div class="mask_info">
              <div class="table_left">
                <tr>
                  <th>店家名稱</th>
                  <td><input type="text" name="store_name" id="store_name" class="add-store-name" value="" placeholder="輸入店家名稱" required></td>
                </tr>
                <br>
                <br>
                <tr>
                  <th>店家編號</th>
                  <td></td>
                </tr>
                <br>
                <br>
                <tr>
                  <th>店家地址</th>
                  <td><input type="text" name="store_address" class="add-store-address" id="store_address" value="" placeholder="輸入店家地址" required></td>
                </tr>
              </div>
              <div class="table_right">
                <tr>
                  <th>店家電話</th>
                  <td><input type="text" name="store_phone" class="store-phone" id="store_phone" value="" placeholder="輸入店家電話號碼" required></td>
                </tr>
                <br>
                <br>

              </div>
            </div>

            <div class="mask_info2">
              <div class="table_left">
                <tr>
                  <th>店家地區分類</th>
                  <br>
                  <td>台北市</td>
                  <td>
                    <select name="store_area_id" class="add-store-area-id store_Area" required></select>
                  </td>
                </tr>
                <br>
                <br>
                <tr>
                  <th>備註</th>
                  <br>
                  <td><input type="text" name="store_memo" class="add-store-memo" id="store_memo" value="" placeholder="內容"></td>
                </tr>
              </div>
              <div class="table_right">
                <tr>
                  <th>店家營業時間</th>
                  <br>
                  <td><input type="text" name="store_time_open" class="add-store-time-open" id="store_time_open" value="" placeholder="填入店家營業時間" required></td>
                </tr>
                <br>
                <br>
                <tr>
                  <th><input type="button" id="submit_add" class="submit-add submit" onclick="" value="新增店家"></th>
                </tr>
                <br>
                <br>
              </div>
            </div>
        </form>
      </div>
    </div>

    <!--隱藏區塊“編輯店家”-->
    <div class="btnMask2" id="btnMask2">
      <i class="fa fa-times fa-4x" aria-hidden="true"></i>
      <div class="Mask_content">
        <div class="mask_title">
          <h5>【編輯】店家資訊</h5>

        </div>
        <div class="mask_info">
          <div class="table_left">
            <tr>
              <th>店家名稱</th>
              <td><input type="text" name="store_name" class="edit-store-name" value="" placeholder="輸入店家名稱" required></td>
            </tr>
            <br>
            <br>
            <tr>
              <th>店家編號</th>
              <td><span class="edit-store-id"></span></td>
            </tr>
            <br>
            <br>
            <tr>
              <th>店家地址</th>
              <td><input type="text" name="store_address" class="edit-store-address" value="" placeholder="輸入店家地址" required></td>
            </tr>
          </div>
          <div class="table_right">
            <tr>
              <th>店家電話</th>
              <td><input type="text" name="store_number" class="edit-store-phone" value="" placeholder="輸入店家電話號碼" required></td>
            </tr>
            <br>
            <br>

          </div>
        </div>

        <div class="mask_info2">
          <div class="table_left">
            <tr>
              <th>店家地區分類</th>
              <br>
              <td>台北市</td>
              <td><select name="store_area_id" class="edit-store-area-id store_Area" required></select></td>
            </tr>
            <br>
            <br>
            <tr>
              <th>備註</th>
              <br>
              <td><input type="text" name="store_note" class="edit-store-memo" value="" placeholder="內容" required></td>
            </tr>


          </div>
          <div class="table_right">
            <tr>
              <th>店家營業時間</th>
              <br>
              <td><input type="text" name="store_time" class="edit-store-time-open" value="" placeholder="填入店家營業時間" required></td>
            </tr>
            <br>
            <br>
            <tr>
              <th><input type="submit" id="submit_eidt" class="submit" value="編輯完成"></th>
            </tr>
            <br>
            <br>
          </div>
        </div>
      </div>
    </div>

    <!--隱藏區塊“刪除店家”-->
    <div class="btnMask3" id="btnMask3">
      <i class="fa fa-times fa-4x" aria-hidden="true"></i>
      <div class="Mask_delete">
        <div class="mask_title">
          <h5>是否要刪除此筆店家資料</h5>
          <p><a href="javascript:;" id="submit_del" data-id="" class=""><img src="images/yesbtn.png"></a>
            <a href="javascript:;" class="cancel-btn"><img src="images/nobtn.png"></a>
          </p>
        </div>
      </div>
    </div>
    </div>
  </section>
<script src="js/jquery-3.5.1.min.js"></script>
<script>
  RT = {}
  RT.content = <?php echo json_encode($rt_content) ?> || {}
  console.log(RT.content)
</script>
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
      url: 'store_process.php',
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
    // console.log(addData)
    $.post({
      url: 'store_process.php',
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
      url: 'store_process.php',
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
  $(".table th a").click(function(e) {
    e.preventDefault();
    var href = $(this).attr("href");
    $('.btnMask1').fadeIn(1000);
    $('.Mask').fadeIn(500);
  });
  $('.btnMask1 .fa-times').click(function() {
    // clearAreaSelect('add-store-area')
    $('.btnMask1,.Mask').fadeOut(500);
  });

  //查看
  $(".table .lookupbtn").click(function(e) {
    e.preventDefault();
    var href = $(this).attr("href");
    $('.btnMask').fadeIn(1000)
    $('.Mask').fadeIn(500);
  });
  $('.btnMask .fa-times').click(function() {
    $('.btnMask,.Mask').fadeOut(500);
  });

  //編輯
  $(".table .editbtn").click(function(e) {
    e.preventDefault();
    var href = $(this).attr("href");
    $('.btnMask2').fadeIn(1000);
    $('.Mask').fadeIn(500);
  });
  $('.btnMask2 .fa-times').click(function() {
    clearAreaSelect('edit-store-area-id')
    $('.btnMask2,.Mask').fadeOut(500);
  });

  //刪除
  $(".deletebtn").click(function(e) {
    e.preventDefault();
    var href = $(this).attr("href");
    $('.btnMask3').fadeIn(1000);
    $('.Mask').fadeIn(500);
  });
  $('.btnMask3 .fa-times ,.cancel-btn').click(function() {
    $('.btnMask3,.Mask').fadeOut(500);
  });

</script>
</body>
</html>
