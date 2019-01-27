@extends('admin::layout/content.blade.php')
@section('title', '操作记录')
@section('content')
    <div class="row rowcontent ">
        <div class="col-sm-12">
            <div class="row padding-bottom-10 padding-top-10 bgwhite">
                <div class="col-sm-5"></div>
                <div class="col-md-offset-3 col-md-4">
                    @widget("admin_search", ["uid"=>"操作人id","ip"=>"ip地址"], $searchField, $searchValue, "操作人id/ip地址")
                </div>
            </div>
            <table class="table table-hover  table-bordered" width="100%">
                <thead>
                <tr>
                    <th width="100px">#</th>
                    <th width="100px">操作人</th>
                    <th width="200px">路由</th>
                    <th width="200px">页面/操作</th>
                    <th width="300px">输入数据</th>
                    <th width="150px">时间</th>
                </tr>
                </thead>
                @if($list)
                <tbody>
                @foreach($list as $v)
                    <tr id="">
                        <td>{{$v['id']}}</td>
                        <td>{{$v['user']['display_name']}}</td>
                        <td>{{$v['route']}}</td>
                        <th>{{$v['access_name']}}</th>
                        <td class="word-wrap">{{$v['input_data']}}</td>
                        <td>@datetime($v['created_at'])</td>
                    </tr>
                @endforeach
                </tbody>
                    @endif
            </table>

        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="dataTables_paginate paging_bootstrap_full_number" style="text-align:center;">
                    @pagi($totalPage, $page, $route, $params)
                </div>
            </div>
        </div>
    </div>
@endsection