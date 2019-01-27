<header class="main-header">
    <a href="@uri('admin::index/index')" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">TRY</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
            <img src="@static('/static/images/adminlogo.png')" style="width: 130px;" />
        </span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="javascript:;" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
            <ul class="nav navbar-nav">
                @if($topNav)
                    @foreach($topNav as $k=>$v)
                        <li class="topmenu @if($topmenu==$k) active @endif"  data-menu="{{$k}}">
                            <a href="javascript:;">{{$v}}</a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{$userinfo['face_img'] empty '/static/images/defaultFace.jpeg'}}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{$userinfo['display_name']}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="{{$userinfo['face_img'] empty '/static/images/defaultFace.jpeg'}}" class="img-circle" alt="User Image">
                            <p>
                                {{$userinfo['display_name']}}
                                <small>{{date('Y-m-d', strtotime($userinfo['created_at']))}} 加入</small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="@uri('admin::base@user@index/setting')" class="btn btn-default btn-flat"> 个人设置</a>
                            </div>
                            <div class="pull-right">
                                <a href="@uri('admin::account/logout')" class="btn btn-danger">退出</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>