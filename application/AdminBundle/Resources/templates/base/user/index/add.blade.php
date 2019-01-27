@extends('admin::layout/content.blade.php')
@section('title', '添加后台用户')
@section('page-bar')
    <li class="nav-tabs-header">
        <a href="@uri('admin::base@user@index/index')">后台用户管理</a>
    </li>
@endsection
@section('content')
    <div class="row rowcontent">

        <input type="hidden" class="js_users_list" data-users="{{$users}}">

        <div class="col-md-6">
            <div class="portlet light">
                <div class="portlet-body form">
                    <form method="post"  class="ajaxform"  action="@uri('admin::base@user@index/doadd')">
                        <div class="form-body">
                            <div class="form-group">
                                <label>账号<span class="required" aria-required="true">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="username" class="form-control input-large" data-required="true" placeholder="账号">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>名称<span class="required" aria-required="true">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="nickname" class="form-control input-large" data-required="true" placeholder="名称">
                                </div>
                            </div>
                            <div class="form-group group_posi_box">
                                <label>权限上级领导<span class="required" aria-required="true"></span></label>
                                <div class="input-group">
                                    <input type="hidden" class="js_report_uid" style="display:none;" value="1" name="report_uid">
                                    <input type="text" value="管理员" name="report_name" autocomplete="off" class="js_report_uname form-control input-large" placeholder="上级领导姓名">
                                </div>
                                <div class="slide_box js_slide_box">
                                    <ul></ul>
                                </div>
                            </div>
                            <div class="form-group" style="display: none">
                                <input type="text" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>用户密码<span class="required" aria-required="true">*</span></label>
                                <div class="input-group">
                                    <input type="password" name="pwd" class="form-control input-large" data-required="true" placeholder="用户密码">
                                </div>
                            </div>
                            <div class="form-group input-large">
                                <label>角色<span class="required" aria-required="true">*</span></label>
                                    @if($roleData)
                                    <select  name="role[]" class="form-control"  multiple="multiple">
                                        @foreach($roleData as $k=>$v)
                                        <option value="{{$v['id']}}">{{$v['text']}}</option>
                                        @endforeach
                                    </select>
                                    @endif
                            </div>
                        </div>
                        <div class="left">
                            <button type="submit" class="btn btn-sm btn-primary">提交</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('css')
    <style>
        .group_posi_box{position: relative;overflow: visible;}
        .group_posi_box .slide_box{display: none; z-index: 6;position: absolute;width: 171px;padding: 10px;border-radius: 6px;background: #fff;top: 59px;left: 0px;border: 1px solid #eee;box-shadow: 0px 2px 8px 0 rgba(0,0,0,.4);max-height:200px;overflow-y:auto;}
        .group_posi_box .slide_box ul{margin: 0;padding: 0;}
        .group_posi_box .slide_box::-webkit-scrollbar{width: 10px;}
        .group_posi_box .slide_box::-webkit-scrollbar-thumb{background: #aaa;border-radius: 6px;}
        .group_posi_box .slide_box li{height: 24px;line-height: 24px;overflow: hidden;cursor:pointer;}

    </style>
@endpush


@push('js')
@static('/static/bundle/admin/js/user_index_add.main.js')
@endpush
