!function(a){a.fn.tips=function(){a(this).each(function(){a(this).css("cursor","pointer"),a(this).click(function(){var t=a(this).attr("title");layer.tips(t,a(this),{tips:[1,"#333643"],time:2500})})})},a.fn.ajaxpage=function(t){var s=a.extend({width:"420px",height:"240px"},t);function i(t,e){var s=4;switch(t){case"tinfo":s=4;break;case"tsuccess":s=1;break;case"terror":s=2;break;case"twarning":s=7;break;default:s=4}layer.msg(e,{time:2500,icon:s})}a(this).each(function(){a(this).click(function(){var t=a(this).attr("href"),e=a(this).data("title");return a.get(t,{},function(t){if("string"==typeof t)t=a.parseJSON(t);a.isEmptyObject(t.result)?t.message.msg&&i(t.message.msgType,t.message.msg):t.message.msg?i(t.message.msgType,t.message.msg):layer.open({title:e,type:1,area:[s.width,s.height],content:t.result})},"json"),!1})})}}(jQuery);