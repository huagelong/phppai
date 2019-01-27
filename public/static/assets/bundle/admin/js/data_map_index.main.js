/**
 * Created by wangkaihui on 2018/4/7.
 */
$(function(){
    var clipboard = new Clipboard('.clipboard');
    clipboard.on('success', function(e) {

        layer.msg("复制成功", {
            time: 2000, //20s后自动关闭
            icon: 1,
            offset: '100px', //右下角弹出
        });

        e.clearSelection();
    });

    $(".tabhref").each(function(){
        $(this).click(function(){
            var id = $(this).data("id");
            $.Cookie('map_option_group', id, { expires: 86400, path: '/'});
        });
    });

    var map_option_group = $.Cookie('map_option_group');
    if(map_option_group){
        $("#taba_"+map_option_group).trigger('click');
    }

    $(".updateoption").each(function(){
        $(this).click(function(){
            var id = $(this).data("id");
            var option_name = $($("input[name='option_name']", "#tr"+id)).val();
            var option_key = $($("input[name='option_key']", "#tr"+id)).val();
            var option_value = $($("input[name='option_value']", "#tr"+id)).val();

            $.post(updateoptionUrl, {id:id, name:option_name, key:option_key, value:option_value}, function(responseText){
                if(typeof  responseText == 'string') var responseText = $.parseJSON(responseText);
                if(!$.isEmptyObject(responseText.result)){
                    if(responseText.message.msg){
                        show(responseText.message.msgType, responseText.message.msg);
                    }
                    setTimeout(function(){
                        location.assign(responseText.result);
                    }, 1000);
                }else{
                    if(responseText.message.msg){
                        show(responseText.message.msgType, responseText.message.msg);
                    }
                }

            })

        });
    });

    function show(msgType, msg){
        var icontype = 4;
        switch(msgType){
            case "tinfo":icontype=4;break;
            case "tsuccess":icontype=1;break;
            case "terror":icontype=2;break;
            case "twarning":icontype=7;break;
            default :icontype = 4;
        }
        // console.log(icontype);
        // console.log(msg);
        layer.msg(msg, {
            time: 2000, //20s后自动关闭
            icon: icontype,
            offset: '100px', //右下角弹出
        });
    }

})