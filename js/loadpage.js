 $(document).ready(function () {
   $('header').load('header.php');
   $('footer').load('footer.php');
 });

 $(function () {
   //tab開頭標籤全部選擇隱藏
   $('div[id^="tab_"]').hide();
   //change事件開始
   $('#storeslt').change(function () {
     let sltValue = $(this).val();
     console.log(sltValue);

     //先隱藏tab、top開頭標籤
     $('div[id^="top_"]').hide();
     $('div[id^="tab_"]').hide();
     //指定選擇顯示
     $(sltValue).show();
   });

 });
