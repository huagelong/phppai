$(function(){
    //search-dropdown
    $.fn.searchdropdown = function() {
        var that  = this;
        var field = $(that).find(".searchField").val();
        if(field){
            $(that).find(".dropdown-menu").find("a").each(function(){
                var afield = $(this).data("field");
                var html = $(this).html();
                if(field == afield){
                    $(that).find(".dropdown-toggle").html(html+"<i class=\"fa fa-angle-down\"></i>");
                }
            });
        }else{
            $(that).find(".dropdown-menu").find("a").each(function(index){
                var afield = $(this).data("field");
                var html = $(this).html();
                if(!index){
                    $(that).find(".dropdown-toggle").html(html+"<i class=\"fa fa-angle-down\"></i>");
                    $(that).find(".searchField").val(afield);
                }
            });
        }


        $(that).each(function(){
            $(this).find(".dropdown-menu").find("a").each(function(){
                $(this).click(function(){
                    var field = $(this).data("field");
                    var html = $(this).html();
                    $(that).find(".dropdown-toggle").html(html+"<i class=\"fa fa-angle-down\"></i>");
                    $(that).find(".searchField").val(field);
                });
            });
        });
    };

    $('.search-dropdown').searchdropdown();

    $(".topmenu").each(function(){
        $(this).click(function(){
            var menu = $(this).data('menu');
            console.log(menu);
            $.Cookie('topmenu', menu, { expires: 86400, path: '/'});
            location.assign(welcome_page);
        });
    });

    $(".sidebar-toggle").each(function(){
        $(this).click(function(){
            var hasSidebarCollapse = $("body").hasClass("sidebar-collapse")?0:1;
            $.Cookie('sidebar-toggle', hasSidebarCollapse, { expires: 86400, path: '/'});
        });
    })


    $(".sidebar a").each(function(){
        var that = $(this);

        $(this).click(function(){
            var route = $(this).data('route');
            if(route){
                $.Cookie('navactive', route, { expires: 86400, path: '/'});
            }
        })

        var navactive = $(that).data('route');
        var cookieNavactive = $.Cookie('navactive');

        if(cookieNavactive){
            if(cookieNavactive == navactive){
                $(that).closest('li').addClass('active');
                $(that).closest('ul').addClass('menu-open');
                $(that).closest('ul').show();
                $(that).closest('.treeview').addClass('active');
            }
        }

    });

    // $(".datepicker").datepicker({
    //     language: "zh-CN",
    //     autoclose: true,//选中之后自动隐藏日期选择框
    //     clearBtn: true,//清除按钮
    //     todayBtn: true,//今日按钮
    // });

    $('.reditor').summernote({
        tabsize: 2,
        height: 100,
        lang: 'zh-CN',
        toolbar: [
            //字体工具
            ['fontname', ['fontname']], //字体系列
            ['style', ['bold', 'italic', 'underline', 'clear']], // 字体粗体、字体斜体、字体下划线、字体格式清除
            ['font', ['strikethrough', 'superscript', 'subscript']], //字体划线、字体上标、字体下标
            ['fontsize', ['fontsize']], //字体大小
            ['color', ['color']], //字体颜色

            //段落工具
            ['style', ['style']],//样式
            ['para', ['ul', 'ol', 'paragraph']], //无序列表、有序列表、段落对齐方式
            ['height', ['height']], //行高

            //插入工具
            ['table',['table']], //插入表格
            ['hr',['hr']],//插入水平线
            ['link',['link']], //插入链接
            ['picture',['picture']], //插入图片
            ['video',['video']], //插入视频

            //其它
            ['fullscreen',['fullscreen']], //全屏
            // ['codeview',['codeview']], //查看html代码
        ],
        callbacks: {
            onImageUpload: function(files) {
                var $editor = $(this);
                var formData = new FormData();
                formData.append('files',files[0]);
                formData.append('code','default');
                $.ajax({
                    url : upyun_url+"?name=files",//后台文件上传接口
                    type : 'POST',
                    data : formData,
                    processData : false,
                    contentType : false,
                    success : function(data) {
                        if(typeof  data == 'string') var data = $.parseJSON(data);
                        // $('#summernote').summernote('insertImage',data,'img');
                        $editor.summernote('insertImage',data.result[1],'img');
                    }
                });
            }
        }
    });

});