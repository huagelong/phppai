@extends('admin::layout/content.blade.php')
@section('title', '缓存管理')
@section('content')

    <div class="row rowcontent">
        <div class="col-sm-12">
            @can("admin::base@data@cache/doClear")
            <a data-confirm="确认清空吗?"  class="btn btn-sm btn-info ajaxload" href="@uri('admin::base@data@cache/doClear')">
                清空redis缓存  <span class="badge badge-info"> {{$redisNum}} </span>
            </a>
            @endcan()
                @can("admin::base@data@cache/doFileClear")
                    <a data-confirm="确认清空吗?"  class="btn btn-sm btn-info ajaxload" href="@uri('admin::base@data@cache/doFileClear')">
                        清空文件缓存  <span class="badge badge-info"> {{$fileNum}} </span>
                    </a>
                @endcan()
                @can("admin::base@data@cache/doCompileClear")
            <a data-confirm="确认清空吗?"  class="btn btn-sm btn-info ajaxload" href="@uri('admin::base@data@cache/doCompileClear')">
                清空模板引擎缓存  <span class="badge badge-info"> {{$compileNum}} </span>
            </a>
                @endcan()
        </div>
    </div>
@endsection