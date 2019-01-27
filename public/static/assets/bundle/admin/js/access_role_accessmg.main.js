/**
 * Created by wangkaihui on 2018/4/7.
 */
$(function(){
    $(".checkall").each(function(){
        $(this).click(function(){
            var check = $(this).is(':checked');
            if(check){
                $(this).closest("td").siblings().find("input").each(function(){
                    $(this).prop("checked", true);
                })
            }else{
                // console.log($(this).closest("tr").html());
                $(this).closest("tr").find("input").each(function(){
                    $(this).prop("checked", false);
                })
            }
        });

    });
});