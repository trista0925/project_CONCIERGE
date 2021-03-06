     <div class="container">
       <nav class="navbar navbar-expand-lg bg-white navbar-light fixed-top">
         <a class="navbar-brand" href="./"><img src="images/logo/Concierge_1.svg" height="55px" alt=""></a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
           <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
           <ul class="navbar-nav ml-auto">
             <li class="nav-item">
               <a class="nav-link login-item" href="?page=register">登入/註冊</a>
             </li>
             <li class="nav-item">
               <a class="nav-link" href="?page=contact">聯絡我們</a>
             </li>
             <li class="nav-item">
               <a class="nav-link" href="?page=qna">常見問題</a>
             </li>
           </ul>
         </div>
       </nav>
     </div>
     <script>
       $(document).ready(function() {
         var loginTmp = (RT.content['mem_mail']) ? RT.content['mem_mail'] : '登入/註冊'
         $('.login-item').text(loginTmp)
       });
     </script>
