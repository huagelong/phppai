@extends('admin::layout/content.blade.php')
@section('title', '编辑角色')
@section('page-bar')
    <li class="nav-tabs-header">
        <a href="@uri('admin::base@access@role/index')">角色管理</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-body form">
                    <form method="post"  class="ajaxform"  action="@uri('admin::base@access@role/doedit')">
                        <div class="form-body">
                            <div class="form-group">
                                <label>角色名称<span class="required" aria-required="true">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="name" value="{{$info['name']}}" class="form-control" data-required="true" placeholder="角色名称">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>角色描述<span class="required" aria-required="true">*</span></label>
                                <div class="input-group">
                                    <textarea class="form-control" rows="3" cols="50" name="descr"  data-required="true" placeholder="角色描述">{{$info['descr']}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="left">
                            <input type="hidden" name="id" value="{{$id}}">
                            <button type="submit" class="btn btn-primary btn-sm">提交</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
