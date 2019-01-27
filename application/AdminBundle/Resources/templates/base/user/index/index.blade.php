@extends('admin::layout/content.blade.php')
@section('title', '后台用户管理')
@section('content')
     <div class="table-toolbar row">
            <div class="col-md-6">
                @can('admin::base@user@index/add')
                <div class="btn-group">
                    <a class="btn btn-sm btn-info" href="@uri('admin::base@user@index/add')">
                        <i class="fa fa-plus"></i> 新增
                    </a>
                </div>
                    @endcan()
            </div>
            <div class="col-md-offset-2 col-md-4">
                @widget("admin_search", ["username"=>"账号", "display_name"=>"昵称"], $searchField, $searchValue, "请输入账号/昵称")
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-hover  table-bordered" width="100%">
                    <thead>
                    <tr>
                        <th width="50px">
                            编号
                        </th>
                        <th width="120px">账号</th>
                        <th width="120px">名称</th>
                        <th width="120px">是否锁定</th>
                        <th width="200px">当前角色</th>
                        <th width="200px">添加时间</th>
                        <th width="100px">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($list)
                        @foreach($list as $k=>$v)
                            <tr>
                                <td>{{$k+1}}</td>
                                <td>{{$v['email']}}</td>
                                <td>{{$v['display_name']}}</td>
                                <td>
                                    @can('admin::base@user@index/lock')
                                        <a href="@uri('admin::base@user@index/lock', ['id'=>$v['id']])"
                                           data-confirm="确认@if($v['is_lock']) 解锁 @else 锁定 @endif吗?" class="ajaxload btn sbold btn-outline btn-sm @if($v['is_lock']) red @else blue @endif">
                                            <i class="@if($v['is_lock']) fa fa-lock  @else fa fa-unlock @endif"></i>
                                        </a>
                                    @endcan($v['is_lock']?"解锁":'锁定')
                                </td>
                                <td>
                                    @if($v['roles'])
                                        @foreach($v['roles'] as $role)
                                            <button class="btn btn-xs btn-primary margin-left-5 margin-bottom-5">{{$role['name']}}</button>
                                        @endforeach
                                    @else
                                        普通会员
                                    @endif
                                </td>
                                <td>@datetime($v['created_at'])</td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-primary dropdown-toggle" href="javascript:;" data-toggle="dropdown" aria-expanded="true">
                                            操作
                                            <i class="fa fa-angle-down"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            @can('admin::base@user@index/edit')
                                                <li>
                                                    <a href="@uri('admin::base@user@index/edit', ['id'=>$v['id']])" >编辑</a>
                                                </li>
                                            @endcan()
                                            @can('admin::base@user@index/editpwd')
                                                <li>
                                                    <a href="@uri('admin::base@user@index/editpwd', ['id'=>$v['id']])" >修改密码</a>
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
@endsection
