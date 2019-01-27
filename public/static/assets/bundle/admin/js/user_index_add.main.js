$(function(){

    var def = {
        timer: null
    }

    var users_list = $('.js_users_list').data('users')||[];
    // console.log(users_list);

    // 姓名输入框焦点下拉
    $('.js_report_uname').on('input propertychange', function() {
        var _val = $(this).val();
        if (_val) {
            $('.js_slide_box').show();
            usersShow(_val)
        }
    })

    // 姓名输入框焦点下拉
    $('.js_report_uname').on('focus', function() {
        if( $('.js_slide_box li').length>0 ){
            $('.js_slide_box').show();
        }
    })

    $('.js_report_uname').blur(function() {
        var _this = $(this);
        clearTimeout(def.timer);
        def.timer = setTimeout(function() {
            $('.js_slide_box').hide();
        }, 200);
    })

    // 添加输入框
    $('.js_slide_box').on('click', 'li', function() {
        var _val = $(this).text();
        var id = $(this).data('id');
        $('.js_report_uname').val(_val);
        $('.js_report_uid').val(id);
        $('.js_slide_box').hide();
    })

    // 名字联动
    function usersShow(_val) {
        $('.js_slide_box').hide();
        _val = _val || '';
        if (_val) {
            var _html = '', _len = users_list.length;
            for (var k = 0; k < _len; k++) {
                var display_name = users_list[k]['display_name'] || '';
                var id = users_list[k]['id'] || '';
                if (display_name && display_name.indexOf(_val) != -1) {
                    _html += '<li data-id="'+id+'">' + display_name + '</li>';
                }
                if( $.trim(_val) == $.trim(display_name) ){
                    $('.js_report_uid').val(id);
                }

            }
            if (_html) {
                $('.js_slide_box ul').html(_html);
                $('.js_slide_box').show();
            }
        }
    }





});