!function(o){o.fn.ajaxform=function(t){var u=o.extend({target:"",dataType:"json",clearForm:!1,resetForm:!1,timeout:1e4,inputParent:".form-group",submitPre:null,submitType:"form",success:null},t);t={target:u.target,beforeSubmit:function(t,r,e){o("button[type='submit']",r).attr("disabled",!0);var a=!0;if(o(u.inputParent,r).each(function(){var s=o(this);o("input,textarea",this).each(function(){var t=o(this).data("required"),e=o(this).val();!t||null!=e&&""!==e?s.removeClass("has-error"):(s.addClass("has-error"),a=!1,o("button[type='submit']",r).attr("disabled",!1)),o(this).focusout(function(){var t=o(this).data("required"),e=o(this).val();t&&e&&s.removeClass("has-error")})})}),a){var i=o('meta[name="csrf-token"]').attr("content"),n=o('meta[name="csrf-uri-token"]').attr("content");i&&o.ajaxPrefilter(function(t,e,s){s.setRequestHeader("X-CSRF-TOKEN",i),s.setRequestHeader("X-CSRF-URI-TOKEN",n)})}return a},success:function(t,e,s,r){if("string"==typeof t)var t=o.parseJSON(t);if(o("button[type='submit']",r).attr("disabled",!1),"200"==t.statusCode){var a=o.Cookie("form_name");a=a||"form",o.Cookie(a,1)}o.isEmptyObject(t.result)||o.isPlainObject(t.result)?t.message.msg&&i(t.message.msgType,t.message.msg):(t.message.msg&&i(t.message.msgType,t.message.msg),setTimeout(function(){location.assign(t.result)},1e3));u.success&&u.success(t);return!1},dataType:u.dataType,clearForm:u.clearForm,resetForm:u.resetForm,timeout:u.timeout};function i(t,e){var s=4;switch(t){case"tinfo":s=4;break;case"tsuccess":s=1;break;case"terror":s=2;break;case"twarning":s=7;break;default:s=4}layer.msg(e,{time:2500,icon:s,offset:"100px"})}o(this).each(function(){"form"==u.submitType?o(this).submit(function(){return o(this).ajaxSubmit(t),!1}):o(this).click(function(){return u.submitPre&&u.submitPre(o(this)),o(this).parents("form").first().ajaxSubmit(t),!1})})}}(jQuery);