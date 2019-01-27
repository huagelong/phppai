@extends('admin::layout/content.blade.php')
@section('title', '文件管理')
@section('content')
    <div class="row margin-bottom-10 rowcontent bgwhite padding-10">
        <div class="col-md-5">
            @can("admin::base@data@attachment/addgroup")
            <div class="btn-group">
                <a class="btn btn-sm btn-info" href="@uri('admin::base@data@attachment/addgroup')"> 新增组
                    <i class="fa fa-plus"></i>
                </a>
            </div>
            @endcan()
                @can("admin::base@data@attachment/deletegroup")
            <div class="btn-group">
                <a class="btn  btn-sm btn-danger ajaxload"  data-confirm="确认删除吗?"  href="@uri('admin::base@data@attachment/deletegroup',['code'=>$code])"> 删除组
                    <i class="fa fa-times"></i>
                </a>
            </div>
                @endcan()
        </div>
        <div class="col-md-offset-2 col-md-3">

        </div>
    </div>

    <div class="row rowcontent">
        <div class="col-sm-12">
                    <ul class="nav  nav-tabs">
                        @if($groups)
                            @foreach($groups  as $gk=>$gv)
                        <li class="@if($code == $gv['code']) active @endif">
                            <a href="@uri('admin::base@data@attachment/index',['code'=>$gv['code']])">{{$gv['name']}} [{{$gv['code']}}]</a>
                        </li>
                            @endforeach
                        @endif
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active">
                            <div class="row padding-bottom-10 padding-top-10">
                                <div class="col-md-5">
                                    <button  class="btn default blue-stripe"> 总数量 :  {{$totalNum}}</button>
                                    <button  class="btn default green-stripe"> 总大小 :  {{$totalSum}} KB</button>
                                </div>
                                <div class="col-md-offset-3 col-md-4">
                                    @widget("admin_search", ["obj"=>"文件对象","originalz_name"=>"文件原始对象","uid"=>"上传人id"], $searchField, $searchValue, "请输入文件对象/文件原始对象/上传人id")
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover  table-bordered" width="100%">
                                        <thead>
                                        <tr>
                                            <th width="200px">文件对象</th>
                                            <th width="200px">文件原始对象</th>
                                            <th width="100px">mime</th>
                                            <th width="100px">文件大小</th>
                                            <th width="100px">添加人</th>
                                            <th width="100px">时间</th>
                                            <th >操作</th>
                                        </tr>
                                        </thead>
                                        @if($list)
                                        <tbody>
                                        @foreach($list as $v)
                                            <tr id="">
                                                <td class="word-wrap">{{$v['obj']}}</td>
                                                <td>{{$v['originalz_name']}}</td>
                                                <td>{{$v['mime']}}</td>
                                                <td>{{$v['size']}}K</td>
                                                <td>{{$v['user']['display_name'] or '-'}}</td>
                                                <td>@datetime($v['created_at'])</td>
                                                <td>
                                                    @can("admin::base@data@attachment/showbind")
                                                    <a  href="@uri('admin::base@data@attachment/showbind', ['id'=>$v['id']])" data-title="查看绑定" class="ajaxpage btn btn-info btn-sm" >查看绑定</a>
                                                    @endcan()
                                                    @can("admin::base@data@attachment/deletefile")
                                                    <a  data-confirm="确认删除吗?" href="@uri('admin::base@data@attachment/deletefile', ['id'=>$v['id']])"  class="ajaxload btn btn-danger btn-sm" >删除</a>
                                                    @endcan()
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                            @endif
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div>
                                    <div class="dataTables_paginate paging_bootstrap_full_number" style="text-align:center;">
                                        @pagi($totalPage, $page, $route, $params)
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
        </div>
    </div>
@endsection