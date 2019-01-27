<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')-{{$siteName or ''}}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="@static('/static/images/fav.png')" />
    @static('/static/assets/lib/kendo-ui/styles/kendo.common.min.main.css')
    @static('/static/assets/lib/kendo-ui/styles/kendo.bootstrap.min.main.css')
    @static('/static/assets/lib/summernote/summernote-lite.main.css')
    @static("/static/assets/lib/base/plugins/layer/layer.main.css")
    @static("/static/assets/bundle/admin/base/css/base.main.css")

    @static('/static/assets/lib/kendo-ui/js/jquery.min.main.js')
    @static('/static/assets/lib/kendo-ui/js/kendo.web.min.main.js')
    @static('/static/assets/lib/kendo-ui/js/cultures/kendo.culture.zh-CN.min.main.js')
    @stack('css')
    <script>
        $(function(){
            kendo.culture("zh-CN");
        })
    </script>
    @static("/static/assets/bundle/admin/base/css/bundle.main.css")
    @stack('js_head')
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body  @yield('body_attr')>
@yield('page')
<script>
    var MODULE_CONFIG = {}
</script>
@static("/static/assets/lib/base/plugins/underscore-min.main.js")
@static("/static/assets/lib/base/ui-load.main.js")
@static("/static/assets/lib/base/ui-include.main.js")
@static("/static/assets/lib/base/ui-jp.main.js")
@static("/static/assets/lib/base/plugins/jqueryForm/jquery.form.main.js")
@static("/static/assets/lib/base/plugins/jquerycookie/jquerycookie.main.js")
@static("/static/assets/lib/base/plugins/layer/layer.main.js")
@static("/static/assets/lib/base/modules/ajaxform.main.js")
@static("/static/assets/lib/base/modules/ajaxload.main.js")
@static("/static/assets/lib/base/modules/widgets.main.js")
@static("/static/assets/lib/base/modules/captcha.main.js")
@static("/static/assets/lib/base/base.main.js")
@static('/static/assets/lib/summernote/summernote-lite.min.main.js')
@static('/static/assets/lib/summernote/lang/summernote-zh-CN.min.main.js')
@static("/static/assets/bundle/admin/base/js/bootstrap.main.js")
@static("/static/assets/bundle/admin/base/js/app.main.js")
@static("/static/assets/bundle/admin/base/js/bundle.main.js")
@stack('js')
</body>
</html>
