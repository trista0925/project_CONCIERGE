//(mem-add-2)
$(document).ready(function() {
    var chk_mail = $("#mem_mail"); //帳號
    var chk_pwd = $("#mem_pwd"); //密碼
    var chk_confirm_pwd = $("#confirm_pwd"); //密碼再次輸入
    // var chk_code         = $("#chkcode");       //驗證碼的輸入

    var test_mail = false; //設定帳號的輸入是否正確,預設為否
    var test_pwd = false; //設定密碼的輸入是否正確,預設為否
    var test_confirm_Pwd = false; //設定確認密碼的輸入是否正確,預設為否
    // var test_chk_code    = false;  //設定驗證碼的輸入是否正確,預設為否

    var msg_blue_start = '<span style="color:#478187">';
    var msg_blue_end = '</span>';
    var m1 = '<span class="str1"></span>';
    var m0 = '<span class="str0"></span>';

    //--------檢測帳號--------------------------------------------------------
    //當游標離開帳號欄位時
    chk_mail.bind("blur", function() {
        //假如欄位內的值不是空的
        if ($(this).val() != "") {
            console.log($(this).val())
            var chk_mail_val = $(this).val(); //取得目前輸入的內容值
            //以 reg 變數設定檢查E-Mail格式的正則表達式(描述字元規則的檢查物件)
            var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;

            //以 reg 物件檢查 chk_mail_val, 符合規則得到true
            if (!reg.test(chk_mail_val)) {
                $('#msg_mail').html('E-Mail格式不符');
                test_mail = false;
            } else {

                //使用AJAX技術取得外部mem_chk_member.php來處理判斷帳號-----------------------------
                $.ajax({
                    //呼叫 mem_chk_member.php進來工作, 以POST方式傳入 chk_mail_val 變數的值
                    url: '?page=member_chk_member',
                    type: 'post',
                    data: {
                        mem_mail: chk_mail_val
                    }

                    //完成ajax的工作後, 執行以下function-------------------------------------------
                }).done(function(msg) { //?page=mem_chk_member完成工作會回傳值, 以 msg 收下回傳的值
                    console.log('--------' + msg);
                    if (msg == 1) { //當收到的值==1, 表示資料庫中已有此帳號
                        $('#msg_mail').html('帳號已存在，不能使用');
                        test_mail = false;
                    } else {
                        $('#msg_mail').html(msg_blue_start + '帳號可以使用' + msg_blue_end);
                        test_mail = true;
                    }
                    //alert('-----'+msg+'------');
                }); //done end ajax end
            } //if chk end
        } //if 空格 end
    }); //blue end

    //當游標點入帳號欄位時
    chk_mail.bind("focus", function() {
        $('#msg_mail').html(''); //將訊息區塊的內容清除
    })

    //--------檢查密碼--------------------------------------------------------
    //當游標在密碼欄位,並且鍵盤有按下放開時
    chk_pwd.bind("keyup", function() {
            var strength = 0; //strength變數負責密碼正確時的積分
            checkStrength(chk_pwd.val()); //將密碼欄位的值傳給checkStrength函數執行函數內的工作

            function checkStrength(pwd) {
                //假如密碼欄位內容值的長度小於6
                if (pwd.length < 6) {
                    $('#msg_pwd').html('密碼未達6個字元');
                    test_pwd = false; //設定pdTest變數為false否定(負責判斷密碼是否正確)
                }
                //假如密碼欄位內容值的長度大於20
                else if (pwd.length > 20) {
                    $('#msg_pwd').html('密碼超過20個字元');
                    test_pwd = false; //設定密碼格式不正確
                } else {
                    //表示密碼格式正確, 設定pdTest變數記錄密碼格式正確
                    test_pwd = true
                    strength += 1; //strength變數累加1,表示積分有1分
                    //假如密碼內容包含有英文字母時,積分再加1分
                    if (pwd.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) { strength += 1 }
                    //假如密碼內容包含有英文字母及數字時,積分再加1分
                    if (pwd.match(/([a-zA-Z])/) && pwd.match(/([0-9])/)) { strength += 1 }
                    //假如密碼內容包含有特殊符號時,積分再加1分
                    if (pwd.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) { strength += 1 }
                    //假如密碼內容包含有二個以上的特殊符號時,積分再加1分
                    if (pwd.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,",%,&,@,#,$,^,*,?,_,~])/)) { strength += 1 }
                    //判斷strength變數記錄積分
                    switch (strength) {
                        case 1: //表示積分為1分時
                            $('#msg_pwd').html(msg_blue_start + '密碼強度:低' + msg_blue_end + m1 + m0 + m0 + m0);
                            break;
                        case 2: //表示積分為2分時
                            $('#msg_pwd').html(msg_blue_start + '密碼強度:中' + msg_blue_end + m1 + m1 + m0 + m0);
                            break;
                        case 3: //表示積分為3分時
                            $('#msg_pwd').html(msg_blue_start + '密碼強度:中' + msg_blue_end + m1 + m1 + m1 + m0);
                            break;
                        case 4: //表示積分為4分時
                            $('#msg_pwd').html(msg_blue_start + '密碼強度:高' + msg_blue_end + m1 + m1 + m1 + m1);
                            break;
                    }
                }
            }
        })
        //當游標點入密碼欄位時
    chk_pwd.bind("focus", function() {
        $('#msg_pwd').html(''); //將訊息區塊的內容清除
    })


    //--------二次密碼核對-----------------------------------------------------
    function chk2pwd() {
        if (chk_confirm_pwd.val() == chk_pwd.val()) {
            $('#msg_confirm_pwd').html(msg_blue_start + '密碼相符' + msg_blue_end);
            test_confirm_Pwd = true;
        } else {
            $('#msg_confirm_pwd').html('密碼不符');
            test_confirm_Pwd = false;
        }
    }

    chk_pwd.bind('blur', function() {
        if (chk_confirm_pwd != '') {
            chk2pwd();
        }
    });

    chk_confirm_pwd.bind("keyup", function() {
        chk2pwd();
    })


    //--------重讀驗證碼-------------------------------------------------------
    $('#re_chkcode').click(function() {
        //console.log('old-------'+test_chk_code);
        //$('#chkcodeimg').html('<img src="conn/createpng.php" alt="">');
        $('#chkcodeimg img').attr('src', 'conn/createImg.php');
        $('#msg_chk_code').html(''); //將訊息區塊的內容清除
        test_chk_code = false;
        //console.log('new-------'+test_chk_code);
    });


    //--------圖形驗證碼核對---------------------------------------------------
    chk_code.bind("keyup", function() {
        var chk_code_input = $(this).val(); //取得目前內容

        $.ajax({ //要載入的是chkImgCode.php, 以POST方式傳入checkCode變數的值
            url: "conn/chkImgCode.php",
            type: "POST",
            data: { chk_code_input: chk_code_input }
        }).done(function(msg) { //處理完成後執行以下function函數
            //alert('chkmsg:'+chkmsg);
            if (msg == 1) {
                $('#msg_chk_code').html(msg_blue_start + '驗證碼正確！' + msg_blue_end);
                test_chk_code = true; //codeTest變數記錄帳號不正確
            } else {
                $('#msg_chk_code').html('驗證碼不正確！');
                test_chk_code = false; //codeTest變數記錄帳號是正確的
            }
        })
    })



    //--------按下註冊鈕時的判斷------------------------------------------------
    $("#addMember").bind("submit", function() {
        //當mailTest,pdTest,conTest,nickTest四個變數皆為true
        if (test_mail && test_pwd && test_confirm_Pwd && test_chk_code) {
            return true; //傳回true
        } else { //否則表示有任何一個錯誤時, 顯示訊息提示
            //var result = '申請表單填寫有錯！請檢查！';
            var result = '';
            var msg_mail = '<br><br>帳號必須以EMail格式申請！';
            var msg_pwd = '<br><br>密碼必須以6~20個字元填寫！';
            var msg_confirm_pwd = '<br><br>確認密碼必須 = 密碼的輸入！';
            var msg_chk_code = '<br><br>必須依左側圖案填寫驗證碼！';

            if (!test_mail) { result += msg_mail; }
            if (!test_pwd) { result += msg_pwd; }
            if (!test_confirm_Pwd) { result += msg_confirm_pwd; }
            if (!test_chk_code) { result += msg_chk_code; }

            //alert(result);
            //(1) alert("填寫有錯！請檢查！\n\r"+"帳號:"+mailTest+"\n\r"+"暱稱:"+nickTest+"\n\r"+"密碼:"+pdTest+"\n\r"+"確認密碼:"+conTest+"\n\r"+"驗證碼:"+codeTest)
            //(2) $('#info').html(result);
            $('#info_modal .info-content').html(result + '<br><br>');
            $('#info_modal').css('display', 'block');

            return false; //傳回false
        }
    })

});