(function ($) {
    //图像处理
    $.fn.captcha = function() {
        var chref = $(this).attr("src");
        $(this).css("cursor", "pointer");
        var chrefTmp = chref+"?"+parseInt(9999*Math.random());
        $(this).attr("src", chrefTmp);
        $(this).click(function(){
            var chrefTmp2 = chref+"?"+parseInt(9999*Math.random());
            $(this).attr("src", chrefTmp2);
        });
    };

    //检查验证码
    $.fn.checkcaptcha = function() {
        var that = $(this);
        $(this).focusout(function(){
            var vl = $(this).val();
            var checkurl = $(this).data('checkurl');
            var errorClass = $(this).data('errorclass');
            var imgObj = $(this).data('img');
            var errorId = $(this).data('errorid');
            // console.log(checkurl);
            // console.log(errorClass);
            // console.log(imgObj);
            // console.log(errorId);
            $.post(checkurl, {vl:vl},function(data){
                if(typeof  data == 'string') var data = $.parseJSON(data);
                if(data.statusCode != "200"){
                    $(errorId).addClass(errorClass);
                    $(imgObj).trigger('click');
                }else{
                    $(errorId).removeClass(errorClass);
                }
            });
        });
    };

}(jQuery));