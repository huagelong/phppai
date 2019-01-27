/**
 * Created by wangkaihui on 2018/12/17.
 */
$(function(){
    $("#selectalltable").click(function(){
        var check = $(this).is(':checked');
        if(check){
            $("input[name='selecttable[]']").each(function(){
                $(this).prop("checked", "true");
            })
        }else{
            $("input[name='selecttable[]']").each(function(){
                $(this).prop("checked", false);
            })
        }
    });
});