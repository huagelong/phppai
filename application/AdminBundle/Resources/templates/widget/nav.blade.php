<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu tree" data-widget="tree">
            @if($nav)
                @foreach($nav as $k=>$v)
                    @if(is_integer($k))
                        <li><a href="@uri($v[0])" data-route="{{$v[0]}}"><i class="{{$v[2] empty 'fa fa-link'}}"></i> <span>{{$v[1]}}</span></a></li>
                    @else
                        <li class="treeview">
                            @php $first = array_shift($v); @endphp
                            <a href="javascript:;"><i class="{{$first[2] empty 'fa fa-link'}}"></i> <span>{{$first[1]}}</span>
                                <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                            </a>
                            @if($v)
                            <ul class="treeview-menu" style="display: none;">
                                @foreach($v as $vv)
                                    <li><a href="@uri($vv[0])" data-route="{{$vv[0]}}"> <span class="{{$vv[2] empty 'fa fa-link'}}"></span> <span>{{$vv[1]}}</span></a></li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                    @endif
                @endforeach
            @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

