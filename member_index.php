<?php
require_once 'shared/conn_PDO.php';
session_start();
if (isset($_SESSION['mem_id']) && $_SESSION['mem_id'] != '') {
    $mem_mail = $_SESSION['mem_mail'];
    $mem_name = $_SESSION['mem_name'];
    $mem_level = $_SESSION['mem_level'];
    // var_dump($mem_level);
} else {
    header('Location: register.php?msg=2');
}

?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes, minimum-scale=1.0, maximum-scale=3.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta charset="UTF-8">
  <title>行動管理員 CONCIERGE｜會員專區</title>
  <link rel="icon" href="LOGO/Concierge_icon.ico">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/animate.css">
</head>

<body class="member-index">
  <section class="container">
    <div class="row pt-lg-4 pb-lg-4">
      <div class="col-lg-2 offset-lg-5 col-6 offset-3">
        <a href="index.php"><img src="LOGO/Concierge_1_white.svg" class="img-fluid" alt=""></a>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-3 offset-lg-3 col-8 offset-2">
        <a id="order_list" href="order.php"><img src="images/order2-01.png" class="img-fluid" alt=""></a>
      </div>
      <div class="col-lg-3 offset-lg-0 col-8 offset-2">
        <a id="order_list" href="member_list.php"><img src="images/order2-02.png" class="img-fluid" alt=""></a>
      </div>
    </div>
    <!--  後台btn  -->
    <div class="row align-items-center">
      <div class="col-lg-5 offset-lg-0 col-5 offset-1">
        <?php if ($mem_level >= 9) {?>
        <a href="order_list.php" name="admin" value=""><img src="images/order2-03.png" class="img-fluid" alt=""></a>
        <?php }?>
      </div>
      <!-- 回上一頁btn -->
      <div class="col-lg-2 offset-lg-5 col-2 offset-2">
        <a href="index.php" class="send-btn" name="back" value="回上一頁">回上一頁</a>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12 text-center text-white">
        <span>會員: <?php echo $mem_name; ?></span>
        <span>帳號: <?php echo $mem_mail; ?></span>
        <a href="member_logout.php" class="logout-submit">登出</a>
      </div>
    </div>
  </section>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
  <script src="js/wow.min.js"></script>
  <script>
    new WOW().init();
    $('.row').addClass('wow animate__animated animate__fadeIn animate__slow');
  </script>
</body>
</html>
