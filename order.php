<?php
require_once('shared/conn_PDO.php');
session_start();
if( !isset($_SESSION['mem_id']) || $_SESSION['mem_id'] == '' ){
  header('Location: register.php?msg=2');
}
/* [ mem_list content ] */
$mem_id   = $_SESSION['mem_id'];
$mem_mail = $_SESSION['mem_mail'];
$mem_name = $_SESSION['mem_name'];
$mem_list = array(
  'mem_id'   => $mem_id,
  'mem_mail' => $mem_mail,
  'mem_name' => $mem_name
);

try {
  /* [ store_list content ] */
  $str = "SELECT store.* 
            FROM store 
            ORDER BY store.store_area_id ASC";
  $RS_storelist = $conn -> query($str);
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

  /* [ area_list content ] */
  $str = "SELECT area.* FROM area ORDER BY area.area_id ASC";
  $RS_area = $conn -> query($str);
  $area_list = array();
  foreach( $RS_area as $key => $item ) {
    $area_list[$item['area_id']] = $item['area_name'];
  }

  /* [ area_store_list content ] */
  $area_store_list = array();
  foreach( $area_list as $area_id => $area_name ) {
    foreach( $store_list as $key => $store_item ) {
      if( $area_id == $store_item['store_area_id'] ) {
        $area_store_list[$area_id][$store_item['store_id']] = array(
          'store_id'      => $store_item['store_id'],
          'store_name'    => $store_item['store_name'],
          'store_area_id' => $store_item['store_area_id'],
          'store_phone'   => $store_item['store_phone'],
          'store_address' => $store_item['store_address'],
          'store_time_open' => $store_item['store_time_open'],
          'store_memo'    => $store_item['store_memo'],
        );
      }
    }
  }

  /* [ rt_content ] */
  $rt_content = array(
    // 'memId'    => $mem_id,
    'mem_list'        => $mem_list,
    'area_list'       => $area_list,
    'area_store_list' => $area_store_list,
    'PHP_SELF'      => $_SERVER['PHP_SELF'],
    'QUERY_STRING'  => $_SERVER['QUERY_STRING'],
    'HTTP_HOST'     => $_SERVER['HTTP_HOST'],
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
    <title>訂單填寫</title>
    <link rel="icon" href="LOGO/Concierge_icon.ico">
    <link rel="stylesheet" href="css/order.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" 
     crossorigin="anonymous">
  </head>

  <header>
    <div class="Order_logo">
      <img src="LOGO/Concierge_1_white.svg">

      <span>訂單填寫</span>
      <span class="user">
          <span>登入會員: <?php echo $mem_name; ?></span>
          <span>登入帳號: <?php echo $mem_mail; ?></span>
          <a href="member_logout.php" class="logout-submit">登出</a>
      </span>
    </div>
  </header>

  <!--內容區-->

  <body>

    <div class="container">

      <div class="row"><?php echo $val ?>
        <div class="col col-lg-2">

          <!--直式標題字-->
          <p style="font-size: 25px;
                    margin-left: 50px;">基<br>本<br>資<br>料</p>
        </div>

        <div class="col-md-5 col-md-5_media">
          <div id="font04">收件者</div>
          <p><input name="ReceiveID" id="ReceiveID" type="text" required="required" value="" maxlength="10" placeholder=""></p>
          <div id="font04">市話</div>
          <p><input name="phone" id="tele" type="text" required="required" value="" maxlength="10" placeholder=""></p>
          <div id="font04">手機</div>
          <p><input name="phone" id="phone" type="text" required="required" value="" maxlength="10" placeholder=""></p>
        </div>

        <div id="wrapper" class="wrapper_media">   
          <p>購物證明</p>
          <form enctype="multipart/form-data" method="POST" action="order_process.php" id="order_file_form">
            <input type="file" name="order_pic" id="fileUpload" class="order_pic"> 
            <input type="hidden" name="order_id" class="hidden-order-id" value="">
            <!-- <input type="submit" value="確定上傳"> -->
          </form>
          <br>
          <br>
          <div id="image-holder"> </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js" ></script>
        <script>
          $("#fileUpload").on('change', function () {

            if (typeof (FileReader) != "undefined") {

              var image_holder = $("#image-holder");
              image_holder.empty();

              var reader = new FileReader();
              reader.onload = function (e) {
                $("<img/>", {
                  "src": e.target.result,
                  "class": "thumb-image"
                }).appendTo(image_holder);

              }
              image_holder.show();
              reader.readAsDataURL($(this)[0].files[0]);
            } else {
              alert("你的浏览器不支持FileReader.");
            }
          });
        </script>
      </div>

      <div class="space"></div>

      <div class="row">
        <div class="col col-lg-2">
          <p style="font-size: 25px;
                    margin-left: 50px;">包<br>裹<br>寄<br>放<br>資<br>訊</p>
        </div>

        <div class="col-md-5 col-md-5_size">
          <div class="form-group col-md-5_size">
            <p>商品大小</p>
            <select class="form-control" id="order_size">
              <option value="0">請選擇</option>
              <option value="1">S型:50公分以下，20公斤以內</option>
              <option value="2">M型:100公分以下，20公斤以內</option>
              <option value="3">L型:150公分以下，20公斤以內</option>
            </select>
          </div>

          <div class="form-group">
            <p>抵達店家時間</p>
            <input type="datetime-local" id="order_time_arrive" class="Order_time" value="">
          </div>

          <div class="form-group">
            <p>預計取件時間</p>
            <input type="datetime-local" id="order_time_get" class="Order_time">
          </div>

          <div class="row">
            <div class="col">   
              <div class="form-group">
                <p>選擇取貨店家</p>
                <select class="form-control area"  id="sel"></select>
              </div>
            </div>
            <div class="col" id="col_right">
              <div class="form-group">
                <select class="form-control"  id="sel2"></select>
              </div>
            </div>
          </div>

          <p id="font04">備註</p>
          <textarea name="mb_content" id="order_memo" rows="5" required="" placeholder="請輸入內容....." style="margin: 5px -51px 5px 0px; height: 100px; width: 444px;"></textarea>
        </div>

        <!--      row結束    -->
      </div>

      <!--    container結束    -->
    </div> 

    <!--    <div class="Ordermap" id="changingpicture"><img src="">-->
    <div class="Ordermap Ordermap_media" id="changingpicture"><img src="" id="Mymap" class="Ordermap_media"></div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <p class="modal-title" id="exampleModalCenterTitle">選擇店舖</p>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" style="padding: 2rem;">

            <header>
              <div class="Order_logo">
                <img src="LOGO/Concierge_1_white.svg">
                <span>確認店家資訊</span>
              </div>
            </header>

            <div class="container container_in">
              <div class="row row_information">
                <div class="col col_laft ">店家名稱:</div>
                <div class="col col_right store_name">Zoeyin_photo</div>
                <div class="w-100"></div>

                <div class="col col_laft">店家電話:</div>
                <div class="col col_right store_phone">(02)2987-6543</div>
                <div class="w-100"></div>

                <div class="col col_laft">店家位置:</div>
                <div class="col col_right store_address">10491台北市中山區民權東路二段78號</div>
                <div class="w-100"></div>

                <div class="col col_laft">營業時間:</div>
                <div class="col col_right store_time_open">周一至周日 07:30–22:00</div>
                <div class="w-100"></div>

                <div class="col col_laft">保管期限:</div>
                <div class="col col_right">三天之內</div>
              </div>
            </div>

            <div class="storephoto"><img class="storephoto-img" src="images/store-1.jpg"></div>
          </div>
        </div>
      </div>
    </div>

    <footer>
      <div class="btndiv">
    
    <a href="member_index.php" class="sendbtn-order"  type="submit" name="back"  value="回上一頁">回上一頁</a>
    
        <a href="javascript:;" class="sendbtn-order" id="sendbtn" type="submit" name="send"  value="送出">送出</a>
        
        
      <div style="clear:both;"></div>
    </div>
    </footer>
  </body>
<script src="js/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"  crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"  crossorigin="anonymous"></script>
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

        //--------(新增)修改過區域----------
        var arraycoords =["177,381,86","599,487,81","856,183,75","379,93,79"];


        $.each(arraycoords,function(j,val) {
          var newarea = document.createElement("area");
          newarea.shape = "circle";
          newarea.coords = arraycoords[j];
          newarea.href = arrayhref[j];
          //newarea.onmouseover = function(){alert("over")};
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
    addData['order_time_arrive']  = $('#order_time_arrive').val()
    addData['order_time_get']   = $('#order_time_get').val()
    // addData['order_pic']     = $('.order_pic').val()
    // addData['order_pic']        = ''
    addData['order_memo']   = $('#order_memo').val()
    // addData['this_url'] = thisUrl
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

    

    // location.href = './orderfinish.php'
})
</script>
</html>