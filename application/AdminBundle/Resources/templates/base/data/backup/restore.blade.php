@extends('admin::layout/content.blade.php')
@section('title', '数据库还原')
@section('content')
    <div class="row rowcontent">
        <div class="col-sm-12">
            <ul class="nav nav-tabs">
                <li>
                    <a href="@uri('admin::base@data@backup/index')">备份</a>
                </li>
                <li class="active">
                    <a href="@uri('admin::base@data@backup/restore')">还原</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active">

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover  table-bordered" width="100%">
                                <thead>
                                <tr>
                                    <th width="180px">名称</th>
                                    <th width="200px">表名</th>
                                    <th width="80px">上传到云</th>
                                    <th width="60px">状态</th>
                                    <th width="200px">创建时间</th>
                                    <th>错误说明</th>
                                    <th  width="100px">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($list)
                                    @foreach($list as $v)
                                        <tr>
                                            <td>
                                                {{$v['name']}} <span class="badge badge-info"> @php $arr = explode(',', $v['tables']); echo count($arr); @endphp </span>
                                            </td>
                                            <td>
                                                <div  class="word-wrap">{{$v['tables']}}</div>
                                            </td>
                                            <td class="text-center">
                                                @if($v['yun_file_id'])
                       <a class="ajaxpage badge badge-success"  href="@uri('admin::base@data@attachment/showbind', ['id'=>$v['yun_file_id']])">是</a>
                                                @else
                                                否
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-success badge-roundless">@option($v['status'], [0=>"失败", 1=>"处理中", 2=>"成功"])</span>
                                            </td>
                                            <td>
                                                @datetime($v['created_at'])
                                            </td>
                                            <td>
                                                @if($v['note'])
                                            <div  class="word-wrap">{{$v['note']}}</div>
                                                    @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a class="btn btn-primary btn-sm dropdown-toggle" href="javascript:;" data-toggle="dropdown" aria-expanded="false">
                                                        操作
                                                        <i class="fa fa-angle-down"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        @can("admin::base@data@backup/doRestore")
                                                        <li>
<a class="ajaxload" data-confirm="确认还原吗?" href="@uri('admin::base@data@backup/doRestore', ['id'=>$v['id']])">还原</a>
                                                        </li>
                                                        @endcan()
                                                            @can("admin::base@data@backup/upyun")
                                                        <li>
 <a class="ajaxload" data-confirm="确认上传吗?" href="@uri('admin::base@data@backup/upyun', ['id'=>$v['id']])">上传到云</a>
                                                        </li>
                                                            @endcan()
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
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