@extends('admin::layout/content.blade.php')
@section('title', '角色管理')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="table-toolbar">
                <div class="row">
                    <div class="col-md-6">
                        @can("admin::base@access@role/add")
                        <div class="btn-group">
                            <a class="btn btn-info btn-sm" href="@uri('admin::base@access@role/add')"> 新增
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                            @endcan()
                    </div>
                    <div class="col-md-offset-2 col-md-4">
                        @widget("admin_search", ["name"=>"名称", "id"=>"ID"], $searchField, $searchValue, "请输入角色名称/ID")
                    </div>
                </div>
            </div>
                <table class="table table-hover table-bordered" width="100%">
                    <thead>
                    <tr>
                        <th width="20px">
                            编号
                        </th>
                        <th width="100px">角色名称</th>
                        <th width="300px">角色描述</th>
                        <th width="200px">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($list)
                        @foreach($list as $k=>$v)
                    <tr>
                        <td>{{$k+1}}</td>
                        <td>{{$v['name']}}</td>
                        <td>{{$v['descr']}}</td>
                        <td>
                            <div class="btn-group">
                               <a class="btn btn-primary btn-sm  dropdown-toggle" href="javascript:;" data-toggle="dropdown" aria-expanded="false">
                                    操作
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    @can("admin::base@access@role/edit")
                                    <li>
                                        <a href="@uri('admin::base@access@role/edit', ['id'=>$v['id']])">编辑</a>
                                    </li>
                                    @endcan()
                                    @can("admin::base@access@role/delete")
                                    <li>
                 <a href="@uri('admin::base@access@role/delete', ['id'=>$v['id']])" data-confirm="确认删除吗?" class="ajaxload">删除</a>
                                    </li>
                                        @endcan()
                                </ul>
                            </div>
                            <a href="@uri('admin::base@access@role/accessMg', ['id'=>$v['id']])" class=" btn btn-success btn-sm">权限管理 <i class="fa fa-expeditedssl"></i></a>
                        </td>
                    </tr>
                         @endforeach
                    @endif
                    </tbody>
                </table>
            <div class="row">
                <div>
                    <div class="dataTables_paginate paging_bootstrap_full_number" style="text-align:center;">
                        @pagi($totalPage, $page, $route, $params)
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
