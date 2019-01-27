@extends('admin::layout/base.blade.php')
@section('body_attr')
    class="hold-transition sidebar-mini skin-black {{$sidebarToggle}}"
@endsection
@section('page')
    <!--[if lt IE 8]>
    <div class="alert alert-danger">您正在使用 <strong>过时的</strong> 浏览器. 是时候 <a target="_blank" href="http://browsehappy.com/">更换一个更好的浏览器</a> 来提升用户体验.</div>
    <![endif]-->
    <div class="wrapper">
        @widget("admin_header")
        @widget("admin_nav")
        <div class="content-wrapper">
            <section class="container-fluid">
                <ul class="nav nav-tabs menu-tabs" role="tablist">
                    @if('admin::index/index'==$routeName)
                        <li class="nav-tabs-header">
                            <a href="javascript:;" style="padding-left: 8px;padding-right: 8px;"><i class="fa fa-chevron-left"></i></a>
                        </li>
                        <li class="nav-tabs-header active">
                            <a href="@uri('admin::index/index')"  style="cursor: pointer">
                                首页
                            </a>
                        </li>
                    @else
                        <li class="nav-tabs-header">
                            <a href="javascript:;" style="padding-left: 8px;padding-right: 8px;" onclick="javascript:history.back(-1);"><i class="fa fa-chevron-left"></i></a>
                        </li>
                        @yield('page-bar')
                        <li class="nav-tabs-header active">
                            <a href="javascript:;"  style="cursor: pointer">
                                @yield('title')
                            </a>
                        </li>
                    @endif

                </ul>
                <div class="tab-content fixheight">
                    <div class="tab-pane active">
                        @yield('main')
                    </div>
                </div>
            </section>
        </div>
        @widget("admin_footer")
    </div>

@endsection
@push('js_head')
<script>
    @if(isset($jsParams) && $jsParams)
    @foreach($jsParams as $k=>$v)
        var {{$k}} = "{{$v}}"
    @endforeach
    @endif
</script>
@endpush
