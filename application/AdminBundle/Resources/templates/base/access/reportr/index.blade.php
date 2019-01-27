@extends('admin::layout/content.blade.php')
@section('title', '汇报关系管理')
@section('content')
    <div class="staff_section js_staff_section">
        <ul class="staff_list_out js_staff_list_out">
        </ul>

    </div>
    <!-- 员工移动 -->
    <div class="add_fix js_set_fix">
        <div class="add_section">
            <div class="add_title">转移到其他分组</div>
            <a href="javascript:void(0);" class="add_close js_add_close list-group-item"><i class="fa fa-remove"></i> 关闭</a>
            <div class="slide_box js_slide_box js_slide_box2">
                <ul></ul>
            </div>
            <form>
                <div>
                    <div class="form-group col-sm-12">
                        <label style="padding: 0 0 0 10px;" class="col-sm-3 control-label">上级领导:</label>
                        <div class="col-sm-9 text_slide_box">
                            <input type="text" autocomplete="off" name="discount" class="form-control js_set_name js_slide_input" value="" placeholder="请输入姓名">
                        </div>
                    </div>

                </div>
                <div class="form-group col-sm-12">
                    <input type="button" value="保存" class="js_remov_btn btn btn-info btn-sm col-sm-3">
                </div>

            </form>
        </div>
    </div>


@endsection
@push('css')
    <style>
        *{margin:0;padding:0;}
        ul{list-style:none;}
        .staff_section {padding: 30px 20px;}

        .staff_list_out {color: #555;font-size: 14px;line-height: 24px;padding: 20px;border: 1px solid #ebebeb;border-radius: 3px;}
        .staff_list_out li {min-height: 24px;}
        .staff_list_out .staff_list {display: none;}

        /* .staff_list_out .hide_type{display: none !important;} */
        .staff_list_out .hide_type {opacity: 0;}
        .staff_list_out .staff_msg {height: 24px;cursor: pointer;}
        .staff_list_out .staff_msg_sec {background: #f1f1f1;}
        .staff_list_out .staff_msg:hover {background: #f1f1f1;}
        .staff_list_out .staff_msg:after {content: '';display: block;clear: both;}
        .staff_list_out .slide_type {display: inline-block;position: relative;width: 12px;height: 12px;}

        .staff_list_out .slide_type:after {display: block;position: absolute;content: '';left: 50%;top: 50%;transform: translate(-50%, -50%);width: 0;height: 0;border-left: 6px solid #999;border-top: 5px solid transparent;
            border-bottom: 5px solid transparent;border-right: 0px solid transparent;}
        .staff_list_out .slide_type1:after {display: block;width: 0;height: 0;border-top: 6px solid #999;border-left: 5px solid transparent;border-right: 5px solid transparent;border-bottom: 0px solid transparent;}
        .staff_list_out .staff_msg>.staff_lable {height: 100%;float: left;}
        .staff_list_out .staff_msg>.staff_lable>span {margin-right: 2px;transition: all .2s linear;}
        .staff_list_out .staff_msg>.staff_btns {height: 100%;float: right;}
        .staff_list_out .staff_msg>.staff_btns>span {cursor: pointer;display: inline-block;height: 100%;padding: 0 4px;}

        .staff_list_out .staff_msg>.staff_btns>span:hover {color: #409eff;}
        .staff_list_out .staff_msg>.staff_btns>span+span {margin-left: 12px;}

        .staff_list_out .staff_list_1 .staff_msg {padding-left: 20px;}
        .staff_list_out .staff_list_2 .staff_msg {padding-left: 60px;}
        .staff_list_out .staff_list_3 .staff_msg {padding-left: 80px;}
        .staff_list_out .staff_list_4 .staff_msg {padding-left: 100px;}
        .staff_list_out .staff_list_5 .staff_msg {padding-left: 120px;}
        .staff_list_out .staff_list_6 .staff_msg {padding-left: 140px;}
        .staff_list_out .staff_list_7 .staff_msg {padding-left: 160px;}

        .staff_list_out .staff_list_8 .staff_msg {padding-left: 180px;}
        .staff_list_out .staff_list_9 .staff_msg {padding-left: 200px;}
        .staff_list_out .staff_list_10 .staff_msg {padding-left: 220px;}
        .staff_list_out .staff_list_11 .staff_msg {padding-left: 240px;}
        .staff_list_out .staff_list_12 .staff_msg {padding-left: 260px;}
        .staff_list_out .staff_list_13 .staff_msg {padding-left: 280px;}
        .staff_list_out .staff_list_14 .staff_msg {padding-left: 300px;}
        .staff_list_out .staff_list_15 .staff_msg {padding-left: 320px;}
        .staff_list_out .staff_list_16 .staff_msg {padding-left: 340px;}
        .staff_list_out .staff_list_17 .staff_msg {padding-left: 360px;}
        .staff_list_out .staff_list_18 .staff_msg {padding-left: 380px;}
        .staff_list_out .staff_list_19 .staff_msg {padding-left: 400px;}
        .staff_list_out .staff_list_20 .staff_msg {padding-left: 420px;}
        .staff_list_out .staff_list_21 .staff_msg {padding-left: 440px;}
        .staff_list_out .staff_list_22 .staff_msg {padding-left: 460px;}
        .staff_list_out .staff_list_23 .staff_msg {padding-left: 480px;}
        .staff_list_out .staff_list_24 .staff_msg {padding-left: 500px;}
        .staff_list_out .staff_list_25 .staff_msg {padding-left: 520px;}
        .staff_list_out .staff_list_26 .staff_msg {padding-left: 540px;}
        .staff_list_out .staff_list_27 .staff_msg {padding-left: 560px;}
        .staff_list_out .staff_list_28 .staff_msg {padding-left: 580px;}
        .staff_list_out .staff_list_29 .staff_msg {padding-left: 600px;}
        .staff_list_out .staff_list_30 .staff_msg {padding-left: 620px;}

        .add_fix{display:none; position: fixed;width: 100%;height: 100%;left:0;top:0;z-index: 100;background: rgba(0,0,0,.3);}
        .add_section{position: absolute;width: 420px;height: auto;  padding: 12px 20px 20px; left:50%;top:20%;transform: translate(-50%,0%); z-index: 100;background:#fff;border-radius: 10px;}
        .add_section .add_title{padding-bottom: 20px;padding-left: 10px;line-height:30px;font-weight: bold;}
        .add_section .add_close{text-align:center;position: absolute;right: 10px;top: 10px;cursor: pointer;padding: 5px;border: 0 none;}

        .form-group{magin-top: 10px;}
        .control-label{height: 30px;line-height: 30px;}


        .add_fix .text_slide_box{position: relative;z-index: 4;}
        .add_fix .slide_box{display: none; z-index: 6;position: absolute;width: 238px;padding: 10px;border-radius: 6px;background: #fff;top: 100px;left: 136px;border: 1px solid #eee;box-shadow: 0px 2px 8px 0 rgba(0,0,0,.4);max-height:200px;overflow-y:auto;}
        /* .add_fix .slide_box{display: none; z-index: 6;position: absolute;width: 238px;padding: 10px;border-radius: 6px;background: #fff;top: 36px;left: 15px;border: 1px solid #eee;box-shadow: 0px 2px 8px 0 rgba(0,0,0,.4);max-height:200px;overflow-y:auto;} */
        .add_fix .slide_box ul{margin: 0;}
        .add_fix .slide_box::-webkit-scrollbar{width: 10px;}
        .add_fix .slide_box::-webkit-scrollbar-thumb{background: #aaa;border-radius: 6px;}

        .add_fix .slide_box li{height: 24px;line-height: 24px;overflow: hidden;cursor:pointer;}

    </style>


@endpush

@push('js')

    <script>
        $(function() {

            var def = {
                current_id: '',
                timer: null
            }

            var _arr = [{!! $list !!}];
            var _users = [{!! $users !!}];
            var users_list = [];

            console.log(_arr, 1)


            if(_users && _users.length){
                users_list = _users[0]||[];
            }

            console.log(users_list, 2)


            // 名字联动
            function usersShow(_val) {
                $('.js_slide_box').hide();
                _val = _val || '';
                if (_val) {
                    var _html = '', _len = users_list.length;
                    for (var k = 0; k < _len; k++) {
                        var display_name = users_list[k]['display_name'] || '';
                        if (display_name && display_name.indexOf(_val) != -1) {
                            _html += '<li>' + display_name + '</li>';
                        }
                    }
                    if (_html) {
                        $('.js_slide_box ul').html(_html);
                        $('.js_slide_box').show();
                    }
                }
            }


            var _index = 0;

            function setList(arr, index) {
                arr = arr || _arr || [];
                index = index || _index;
                var _html = '', len = arr.length;

                for (var i = 0; i < len; i++) {

                    arr[i]._index = index + 1;
                    var _name = arr[i].name || '';
                    var _id = arr[i].id || '';
                    var _chilren = arr[i].children || [];
                    var _chtml = '';

                    var hide_type = '';
                    if (!_chilren || _chilren.length <= 0) {
                        hide_type = 'hide_type';
                    }

                    _html += '<li data-id="' + _id + '" data-name="' + _name +
                        '"><div class="staff_msg"><div class="staff_lable"><span class="slide_type ' +
                        hide_type + '"></span><span class="staff_star">' + _name + '</span></div>';
                    _html += '<div class="staff_btns js_staff_btns" data-id="' + _id + '" data-name="' + _name +
                        '"> <span  class="js_staff_set">转移</span> </div>';
                    _html += '</div><ul class="staff_list staff_list_' + arr[i]._index + '">';

                    if ( !hide_type ) {
                        _chtml = setList(_chilren, arr[i]._index) || '';
                    }

                    _html += _chtml;
                    _html += '</ul></li>';

                }

                _html = _html || '';
                return _html;
            }


            var list_html = setList();
            $('.js_staff_list_out').html(list_html);


            // 下拉
            $('.js_staff_list_out .staff_msg').on('click', function() {
                var _li = $(this).parent('li');
                var slide_type = $(this).find('.slide_type');
                var _staff_list = _li.find('ul').eq(0);
                if (slide_type.hasClass('slide_type1')) {
                    slide_type.removeClass('slide_type1');
                    _staff_list.stop(true, true).slideUp();
                } else {
                    slide_type.addClass('slide_type1');
                    _staff_list.stop(true, true).slideDown();
                }

            })


            $('.js_staff_btns').on('click', function(e) {
                e = e || event;
                if (e && e.stopPropagation) {
                    e.stopPropagation();
                } else {
                    window.event.cancelBubble = true;
                }
                return false;
            })


            // 姓名输入框焦点下拉
            $('.js_slide_input').on('input propertychange', function() {
                var _val = $(this).val();
                if (_val) {
                    $('.js_slide_box').show();
                    usersShow(_val)
                }
            })

            // 姓名输入框焦点下拉
            $('.js_slide_input').on('focus', function() {
                if( $('.js_set_fix .js_slide_box li').length>0 ){
                    $('.js_set_fix .js_slide_box').show();
                }
            })

            $('.js_slide_input').blur(function() {
                var _this = $(this);
                clearTimeout(def.timer);
                def.timer = setTimeout(function() {
                    $('.js_set_fix .js_slide_box').hide();
                }, 200);

            })

            // 添加输入框
            $('.js_slide_box').on('click', 'li', function() {
                var _val = $(this).text();
                $('.js_slide_input').val(_val);
                $('.js_slide_box').hide();
            })



            $('.js_add_close').on('click', function(e) {
                $('.add_fix').hide();
            })


            // 转移分组
            $('.js_staff_set').on('click', function(e) {
                var staff_btns = $(this).parent('.js_staff_btns').eq(0);
                var _id = staff_btns.data('id')||'';
                console.log(_id);
                $('.js_set_fix form')[0].reset();
                def.current_id = _id;
                // $('.js_set_fix .js_set_name').val(_name);
                $('.js_set_fix').show();
            })

            // 提交转移
            $('.js_remov_btn').on('click', function(e) {
                var _name = $.trim( $('.js_set_fix .js_slide_input').val() ), _id='';
                users_list.forEach(function(v){
                    var _n = $.trim( v.display_name );
                    if( _n == _name ){
                        _id = $.trim( v.id );
                    }
                });
                if(_id){
                    removFun(_id);
                }else{
                    layer.msg('没有找到该领导，请重新输入', {
                        time: 2000,
                        icon: 2
                    })
                }
            })


            // 转移分组
            function removFun(_id){
                $.ajax({
                    url: '/admin/access/update_reportr',
                    type: 'post',
                    data: { report_uid: _id, uid: def.current_id },
                    success: function(data){
                        if( typeof data == 'string' ){
                            data = JSON.parse(data);
                        }
                        data = data||{};
                        var statusCode = data.statusCode||200, _msg='';
                        var message = data.message||{};
                        if(statusCode == 200){
                            if( typeof message == 'string' ){
                                _msg == '转移分组成功';
                            }else{
                                _msg = message.msg || '转移分组成功';
                            }
                            layer.msg(_msg, {
                                time: 2000,
                                icon: 1
                            });
                            setTimeout(function(){
                                window.location.reload();
                            }, 2000);
                        }else{
                            if( typeof message == 'string' ){
                                _msg == '转移分组失败';
                            }else{
                                _msg = message.msg || '转移分组失败';
                            }
                            layer.msg(_msg, {
                                time: 2000,
                                icon: 2
                            })
                        }

                    }

                })

            }



        })

    </script>

@endpush