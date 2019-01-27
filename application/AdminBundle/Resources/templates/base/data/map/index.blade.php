@extends('admin::layout/content.blade.php')
@section('title', '字典管理')
@section('content')
    <div class="row rowcontent">
        <div class="col-sm-12">
            <div class="table-toolbar">
                <div class="row">
                    <div class="col-md-5">
                        @can("admin::base@data@map/add")
                        <div class="btn-group">
                            <a class="btn btn-sm btn-info" href="@uri('admin::base@data@map/add')"> 新增字典
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                            @endcan()
                    </div>
                    <div class="col-md-offset-3 col-md-4">
                        @widget("admin_search", ["group_name"=>"字典名称", "group_key"=>"字典KEY"], $searchField, $searchValue, "请输入字典名称/字典key")
                    </div>
                </div>
            </div>
             <div class="row" style="margin-top: 10px;">
                        <div class="col-md-2">
                            @if($list)
                            <ul class="nav nav-stacked nav-stacked-custome nav-tabs nav-left">
                                @foreach($list as $k=>$v)
                                <li @if($k==0) class="active" @endif>
                                    <a href="#tab_{{$v['id']}}" id="taba_{{$v['id']}}" data-toggle="tab" aria-expanded="true" data-id="{{$v['id']}}" class="tabhref"> {{$v['group_name']}} </a>
                                </li>
                                @endforeach
                            @endif
                            </ul>
                        </div>
                        <div class="col-md-10">
                            <div class="tab-content">
                                @if($list)
                                    @foreach($list as $k=>$v)
                                <div class="tab-pane  @if($k==0) active @endif in" id="tab_{{$v['id']}}">
                                        <div class="row margin-bottom-10">
                                            <div class="col-md-5">
                                                <div class="btn-group">
                                                    <a class="btn  btn-sm btn-primary" href="javascript:;" data-toggle="dropdown" aria-expanded="false">
                                                        字典操作
                                                        <i class="fa fa-angle-down"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        @can("admin::base@data@map/del")
                                                        <li>
                                                            <a class="ajaxload" data-confirm="确认删除吗?" href="@uri('admin::base@data@map/del',['id'=>$v['id']])">
                                                                删除字典
                                                            </a>
                                                        </li>
                                                        @endcan()
                                                            @can("admin::base@data@map/edit")
                                                        <li>
                                                            <a href="@uri('admin::base@data@map/edit',['id'=>$v['id']])">
                                                                编辑字典
                                                            </a>
                                                        </li>
                                                            @endcan()
                                                    </ul>
                                                </div>
                                                @can("admin::base@data@map/addoption")
                                                <div class="btn-group">
                                                    <a class="btn btn-outline btn-sm btn-info" href="@uri('admin::base@data@map/addoption',['groupid'=>$v['id']])">
                                                        增加字典数据 <i class="fa fa-plus"></i>
                                                    </a>
                                                </div>
                                                @endcan()
                                            </div>
                                            <div class="col-md-offset-5 col-md-2">

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                @if($v['option_list'])
                                                    <table class="table table-hover  table-bordered" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th width="300px">数据名称</th>
                                                            <th width="200px">数据key</th>
                                                            <th>数据value</th>
                                                            <th width="200px">操作</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($v['option_list'] as $ol)
                                                            <tr id="tr{{$ol['id']}}">
                                                                <td>
                                                                   <input type="text" class="form-control"  name="option_name" value="{{$ol['option_name']}}">
                                                                </td>
                                                                <td>
                                              <input type="text" class="form-control"  name="option_key" value="{{$ol['option_key']}}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"  name="option_value" value="{{$ol['option_value']}}">
                                                                </td>
                                                                <td>
                                                                    @can("admin::base@data@map/updateoption")
                                                                    <a  data-id="{{$ol['id']}}" class="btn btn-sm btn-success updateoption" >保存</a>
                                                                    @endcan()
                                                                        @can("admin::base@data@map/deloption")
                                                                    <a  data-confirm="确认删除吗?" href="@uri('admin::base@data@map/deloption',['id'=>$ol['id']])"  class="ajaxload btn btn-danger btn-sm " >删除</a>
                                                                        @endcan()
                                                                    <a   data-clipboard-text="'{{$v['group_key']}}','{{$ol['option_key']}}'" class="clipboard btn  btn-primary btn-sm" >复制</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>

                                                @endif
                                            </div>
                                        </div>
                                </div>
                                    @endforeach
                                @endif
                            </div>
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
@endsection

@push('js')
<script>
var updateoptionUrl = "@uri('admin::base@data@map/updateoption')";
</script>
@static('/static/lib/clipboardjs/clipboard.min.main.js')
@static('/static/bundle/admin/js/data_map_index.main.js')
@endpush