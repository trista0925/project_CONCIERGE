<?php
require_once 'shared/conn_PDO.php';
session_start();
if (!isset($_SESSION['mem_id']) || $_SESSION['mem_id'] == '') {
    header('Location: register.php?msg=2');
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
    /* [ store_list content ] */
    $str = "SELECT store.*
            FROM store
            ORDER BY store.store_area_id ASC";
    $RS_storelist = $conn->query($str);
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

    /* [ area_list content ] */
    $str = "SELECT area.* FROM area ORDER BY area.area_id ASC";
    $RS_area = $conn->query($str);
    $area_list = array();
    foreach ($RS_area as $key => $item) {
        $area_list[$item['area_id']] = $item['area_name'];
    }

    /* [ area_store_list content ] */
    $area_store_list = array();
    foreach ($area_list as $area_id => $area_name) {
        foreach ($store_list as $key => $store_item) {
            if ($area_id == $store_item['store_area_id']) {
                $area_store_list[$area_id][$store_item['store_id']] = array(
                    'store_id' => $store_item['store_id'],
                    'store_name' => $store_item['store_name'],
                    'store_area_id' => $store_item['store_area_id'],
                    'store_phone' => $store_item['store_phone'],
                    'store_address' => $store_item['store_address'],
                    'store_time_open' => $store_item['store_time_open'],
                    'store_memo' => $store_item['store_memo'],
                );
            }
        }
    }

    /* [ rt_content ] */
    $rt_content = array(
        // 'memId'    => $mem_id,
        'mem_list' => $mem_list,
        'area_list' => $area_list,
        'area_store_list' => $area_store_list,
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
    <title>行動管理員 CONCIERGE｜訂單填寫</title>
    <link rel="icon" href="LOGO/Concierge_icon.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
     crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/animate.css">
  </head>
  <body>
  <section class="order container-fluid no-any-pd">
      <a href="index.php"><img src="LOGO/Concierge_1_white.svg" class="img-fluid"></a><h2>訂單填寫</h2>
      <div class="order-head">
      <span>會員：<?php echo $mem_name; ?></span>
      <span>帳號：<?php echo $mem_mail; ?></span>
      <a href="member_logout.php" class="logout-submit">登出</a>
      </div>
  </section>
  <section class="container">
      <div class="row order-info pt-lg-5 pt-3"><?php echo $val ?>
        <div class="col-lg-1 offset-lg-2">
          <h3 class="text-vertical">基本資料</h3>
        </div>
        <div class="col-lg-5">
          <p>收件者</p>
          <input type="text" class="form-control" name="ReceiveID" id="ReceiveID" required="required" value="" maxlength="10" placeholder="請輸入姓名">
          <p>市話</p>
          <input type="text" class="form-control" name="telephone" id="tele" required="required" value="" maxlength="10" placeholder="請輸入家用/公司電話">
          <p>手機</p>
          <input type="text" class="form-control" name="phone" id="phone" required="required" value="" maxlength="10" placeholder="請輸入手機號碼">
        </div>
        <div class="col-lg-3">
        <p>購物證明</p>
          <form enctype="multipart/form-data" method="POST" action="order_process.php" id="order_file_form">
          <div class="custom-file">    
            <input type="file" class="custom-file-input" id="fileUpload" name="order_pic">    
            <label class="custom-file-label" for="fileUpload" style="overflow: hidden;">選擇檔案</label>
          </div>
          <input type="hidden" class="hidden-order-id" name="order_id" value="">
          </form>
          <div id="image-holder"></div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script>
// Bootstrap 4上傳檔案介面無法顯示檔案路徑或檔名解決
          $(document).ready(function(){
  $(".custom-file-input").change(function () {
    $(this).next(".custom-file-label").html($(this).val().split("\\").pop());
  });
});
// Bootstrap 4上傳檔案介面無法顯示檔案路徑或檔名解決
   $("#fileUpload").on('change', function () {
     if (typeof (FileReader) != "undefined") {
      var image_holder = $("#image-holder");
          image_holder.empty();
      var reader = new FileReader();
          reader.onload = function (e) {
            $("<img/>", {
              "src": e.target.result,
              "class": "order-image"
            }).appendTo(image_holder);
          }
          image_holder.show();
          reader.readAsDataURL($(this)[0].files[0]);
          } else {
            alert("您的瀏覽器不支持FileReader");
          }
      });
  </script>
      </div>
      <div class="row order-info pt-lg-5 pt-5 pb-lg-3 pb-3">
        <div class="col-lg-1 offset-lg-2">
        <h3 class="text-vertical">包裹寄放資訊</h3>
        </div>
        <div class="col-lg-6">
            <p>商品大小</p>
            <select class="form-control" id="order_size">
              <option value="0">請選擇</option>
              <option value="1">S型:50公分以下，20公斤以內</option>
              <option value="2">M型:100公分以下，20公斤以內</option>
              <option value="3">L型:150公分以下，20公斤以內</option>
            </select>
            <p>抵達店家時間</p>
            <input type="datetime-local" class="form-control" id="order_time_arrive" value="">
            <p>預計取件時間</p>
            <input type="datetime-local" class="form-control" id="order_time_get">
            <p>選擇取貨店家</p>
            <div class="input-group-prepend">
            <select class="form-control area" id="sel"></select>
            <select class="form-control" id="sel2"></select>
            </div>
            <p>備註</p>
            <textarea class="form-control" name="mb_content" id="order_memo" rows="5" required="" placeholder="請輸入內容....."></textarea>
        </div>
      </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <p class="modal-title" id="exampleModalCenterTitle">選擇店舖
            </p>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="order-shop-logo">
              <img src="LOGO/Concierge_1_white.svg" class="img-fluid">
              <span>確認店家資訊</span>
            </div>
            <div class="order-shop-info">
              <div>
                <p>店家名稱：<span class="store_name">Zoeyin_photo</span></p>
                <p>店家電話：<span class="store_phone">(02)2987-6543</span></p>
                <p>店家位置：<span class="store_address">10491台北市中山區民權東路二段78號</span></p>
                <p>營業時間：<span class="store_time_open">周一至周日 07：30–22：00</span></p>
                <p>保管期限：三天之內</p>
              </div>
              <img src="images/store-1.jpg" class="img-fluid">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="order-map" id="changingpicture"><img src="" id="Mymap">
  </div>
  <div class="order-btn pd-top pd-bottom">
  <a href="member_index.php" type="submit" name="back" value="回上一頁">回上一頁</a>
  <a href="javascript:;" id="sendbtn" type="submit" name="send" value="送出">送出</a>
  </div>
  </body>
  <script src="js/jquery-3.5.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"  crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"  crossorigin="anonymous"></script>
<script src="js/wow.min.js"></script>
   <script>
    new WOW().init();
    $('.container').addClass('wow animate__animated animate__fadeIn animate__slow');
  </script>
  <script>
  RT = {}
  RT.content = <?php echo json_encode($rt_content) ?> || {}
  RT.content.sizeData = {
    '1': 'S型:50公分以下，20公斤以內',
    '2': 'M型:100公分以下，20公斤以內',
    '3': 'L型:150公分以下，20公斤以內',
  }
  console.log(RT.content)
  </script>
  <script>
  function renderStoreArr(areaId) {
    var areaStoreObj = RT.content['area_store_list'][areaId] || {}
    var areaStoreList = [{'store_name': '請選擇店家', 'store_id': 0}]
    Object.values(areaStoreObj).forEach((v,k) => {areaStoreList.splice(k+1, 0, v)})
    // console.log(areaStoreList)
    return areaStoreList
  }
  function renderAreaOption(el) {
    var areaObj = RT.content['area_list'] || {}
    var areaList = ['請選擇地區']
    Object.values(areaObj).forEach((v,k) => { areaList.splice(k+1, 0, v)})
    $.each(areaList, function(i, val) {
          $(el).append($( `<option value=${i}>${val}</option>` ));
    });
  }
  function renderStoreOption(el, arr) {
    $.each(arr, function(i, val) {
          $(el).append($( `<option value=${val['store_id']}>${val['store_name']}</option>` ));
    });
  }

  $("#sel").change(function(){
    var picturepath="";
    var imge = $("#changingpicture").find("img");
    var newmap = document.createElement("map");
    newmap.name = "MapImg";
    var areaId = parseInt($(this).val())
    var array = renderStoreArr(areaId)
        $("#sel2 option").remove();
        renderStoreOption('#sel2', array)
        console.log(areaId)
    var arrData = Object.values(RT.content['area_store_list'][areaId]).map((v,k)=>{ return v })
    var arrayhref = arrData.map((v,k) => { return v['store_id'] })
    switch (areaId){
      case 0:
        picturepath="";
        imge.attr("src", picturepath);
        break;

      case 1:
        picturepath="images/map/v1.jpg";
        imge.attr("src", picturepath);
        var arraycoords =["856,183,75","599,487,81","177,381,86","379,93,79"];

        $.each(arraycoords,function(j,val) {
          var newarea = document.createElement("area");
          newarea.shape = "circle";
          newarea.coords = arraycoords[j];
          newarea.href = arrayhref[j];
          newmap.appendChild(newarea);
        });

        var getdiv = document.getElementById("changingpicture");
        getdiv.appendChild(newmap);

        var getimg = document.getElementById("Mymap");
        getimg.setAttribute('usemap', "#MapImg");

        //------------END--------------
        break;

      case 2:
        picturepath="images/map/v2.jpg";
        imge.attr("src", picturepath);
        break;

      case 3:
        picturepath="images/map/v3.jpg";
        imge.attr("src", picturepath);
        break;

      case 4:
        picturepath="images/map/v4.jpg";
        imge.attr("src", picturepath);
        break;

      case 5:
        picturepath="images/map/v5.jpg";
        imge.attr("src", picturepath);
        break;

      case 6:
        picturepath="images/map/v6.jpg";
        imge.attr("src", picturepath);
        break;

      case 7:
        picturepath="images/map/v7.jpg";
        imge.attr("src", picturepath);
        break;

      case 8:
        picturepath="images/map/v8.jpg";
        imge.attr("src", picturepath);
        break;

      case 9:
        picturepath="images/map/v9.jpg";
        imge.attr("src", picturepath);
        break;

      case 10:
        picturepath="images/map/v10.jpg";
        imge.attr("src", picturepath);
        break;

      case 11:
        picturepath="images/map/v11.jpg";
        imge.attr("src", picturepath);
        break;

      case 12:
        picturepath="images/map/v12.jpg";
        imge.attr("src", picturepath);
        break;

      default:
        imge.attr("src","");
        $("#sel2 option").remove();
        break;
    }

    $('area').click(function(e){
      e.preventDefault();
      var getmap=$(this).attr('href');
      var mapData = RT.content['area_store_list'][areaId][getmap]
      console.log(getmap)
      $('.store_address').text(mapData['store_address'])
      $('.store_name').text(mapData['store_name'])
      $('.store_phone').text(mapData['store_phone'])
      $('.store_time_open').text(mapData['store_time_open'])
      $('.storephoto-img').attr('src', `images/store-${getmap}.jpg`)

      $('.modal').modal();
    });
  });
  </script>
  <script>
  $(document).ready(function() {
  renderAreaOption('.area')
  })

  $('#sendbtn').click(function() {
  var area_id = $('#sel').val()
  var addData = {}
    addData['process']          = 'insert'
    addData['order_mem_id']     = RT.content['mem_list']['mem_id']
    addData['order_name']       = $('#ReceiveID').val() || RT.content['mem_list']['mem_name']
    addData['order_mail']       = RT.content['mem_list']['mem_mail']
    addData['order_store_id']   = $('#sel2').val()
    addData['order_store_name'] = RT.content['area_store_list'][area_id][addData['order_store_id']]['store_name']
    addData['order_phone']      = $('#phone').val()
    addData['order_tele']       = $('#tele').val()
    addData['order_size']       =  RT.content['sizeData'][$('#order_size').val()]
    addData['order_time_arrive']= $('#order_time_arrive').val()
    addData['order_time_get']   = $('#order_time_get').val()
    addData['order_memo']       = $('#order_memo').val()
    console.log(addData)

    $.ajax({
        type: 'post',
        url: 'order_process.php',
        data: addData,
        crossDomain: true,
      }).done(function(order_id) {
        $('.hidden-order-id').val(order_id)
        console.log('hidden-order-id')
        console.log($('.hidden-order-id').val())
        $('#order_file_form').submit();
      })
      .fail(function(XMLHttpRequest, textStatus, errorThrown) {
        console.log('XMLHttpRequest:'+XMLHttpRequest)
        console.log('status:'+XMLHttpRequest.status)
        console.log('readyState:'+XMLHttpRequest.readyState)
        console.log('status:'+textStatus)
      })
  })
  </script>
</html>