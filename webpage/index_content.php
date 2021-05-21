
<?php
require_once 'shared/conn_PDO.php';
session_start();

if (isset($_SESSION['mem_id']) || $_SESSION['mem_id'] == '') {
    $mem_mail = $_SESSION['mem_mail'];
}
try {
    $rt_content = array(
        'mem_mail' => $mem_mail,
    );
} catch (PDOException $e) {
    die("Error!: " . $e->getMessage());
}
?>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes, minimum-scale=1.0, maximum-scale=3.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta charset="UTF-8">
  <title>行動管理員 CONCIERGE</title>
  <link rel="icon" href="LOGO/Concierge_icon.ico">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/animate.css">
</head>
<body>
<header></header>
<section class="container-fluid">
    <div class="row">
    <img src="images/slider.jpg" class="card-img h-100" alt="">
    </div>
    <div class="row btnset-index justify-content-center">
      <a href="?page=store" class="btn btn-primary p-3 m-3 btn-lg active" role="button" aria-pressed="true">查看合作商家</a>
      <a href="?page=register" class="btn btn-primary p-3 m-3 btn-lg active" role="button" aria-pressed="true">開始使用</a>
    </div>
  </section>
  <section class="container pd-top-lg pd-bottom-lg">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="text-center">服務介紹<br>How to use</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4 pd-top">
        <div class="step-icon">1</div>
        <h3 class="text-center">尋找管理員</h3>
        <p class="text-center">尋找鄰近的合作商家<br>這些商家會提供安全的貨物寄放空間</p>
      </div>
      <div class="col-lg-4 pd-top">
      <div class="step-icon">2</div><h3 class="text-center">線上預訂</h3>
      <p class="text-center">註冊會員並完成線上預訂<br>可至會員訂單系統確認訂單資訊</p>
      </div>
      <div class="col-lg-4 pd-top">
      <div class="step-icon">3</div><h3 class="text-center">取回包裹</h3>
      <p class="text-center">當貨物抵達店家時<br>請至店家出示身份證件取回包裹</p>
      </div>
    </div>
  </section>
  <section class="container-fluid pd-top-lg pd-bottom-lg sec-bg-color">
    <div class="row">
      <div class="col-lg-12 mb-4">
        <h2 class="text-center">寄放價格<br>Prices</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3">
        <h4>常溫<br>TWD 50 元/件</h4>
      </div>
      <div class="col-lg-7 offset-lg-1">
        <p class="text-white">一般常溫包裹（一般包裹、行李託運、飯店行李託運、喜餅、電腦主機、網拍......等）<br>
          尺寸在150公分以下(長+寬+高三邊合計)，20公斤以內。</p>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-10 offset-lg-1">
        <hr>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3">
        <h4>冷藏/冷凍<br>TWD 80 元/件</h4>
      </div>
      <div class="col-lg-7 offset-lg-1">
        <p class="text-white">一般低溫（冷藏、冷凍）包裹，尺寸在120公分以下，20公斤以內，<br>
          宅配前務必將低溫包裹預冷6小時至冷藏狀態，或12小時至冷凍狀態，且確認未漏水。</p>
      </div>
    </div>
  </section>
  <section class="container pd-top-lg pd-bottom-lg">
    <div class="row">
      <div class="col-lg-12 mb-4">
        <h1 class="text-center">特色<br>Features</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4 pd-bottom">
        <img class="img-fluid" src="images/Features_1.png" alt="">
        <h3 class="text-center">便利</h3>
        <p class="text-center">住在無人收件的公寓、大樓<br>
          導致常常收不到包裹嗎?<br>
          行動管理員提供鄰近你的商家存放包裹<br>
          讓整個城市都是你的管理員</p>
      </div>
      <div class="col-lg-4 pd-bottom">
        <img class="img-fluid" src="images/Features_2.png" alt="">
        <h3 class="text-center">安全</h3>
        <p class="text-center">合作商家均嚴格審核<br>
          包裹會寄放在有人員看管的地方<br>
          每件包裹提供最高台幣 5000 元保險金
        </p>
      </div>
      <div class="col-lg-4 pd-bottom">
        <img class="img-fluid" src="images/Features_3.png" alt="">
        <h3 class="text-center">店家優惠</h3>
        <p class="text-center">包裹取件的同時<br>
          可獲得店家提供的相關商品折扣
        </p>
      </div>
    </div>
    <div class="py-3 row btnset-index justify-content-center">
      <a href="?page=register" class="btn btn-primary p-3 m-3 btn-lg active" role="button" aria-pressed="true">開始使用</a>
    </div>
  </section>
  <footer class="pd-top pd-bottom sec-bg-color"></footer>
<script>
    RT = {}
    RT.content = <?php echo json_encode($rt_content); ?> || {}
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  <script src="js/jquery-3.5.1.min.js"></script>
  <script src="js/loadpage.js"></script>
  <script src="js/wow.min.js"></script>
  <script>
    new WOW().init();
    $('.row').addClass('wow animate__animated animate__fadeIn animate__slow');
  </script>
    <script>
       $(document).ready(function() {
         var loginTmp = (RT.content['mem_mail']) ? RT.content['mem_mail'] : '登入/註冊'
         $('.login-item').text(loginTmp)
       });
     </script>
</body>
</html>