@extends('admin::layout/content.blade.php')
@section('title', '编辑字典')
@section('page-bar')
    <li class="nav-tabs-header">
        <a href="@uri('admin::base@data@map/index')">字典管理</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-body form">
                    <form method="post"  class="ajaxform"  action="@uri('admin::base@data@map/doedit',['id'=>$info['id']])">
                        <div class="form-body">
                            <div class="form-group">
                                <label>字典名称<span class="required" aria-required="true">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="name" value="{{$info['group_name']}}" class="form-control" data-required="true" placeholder="字典名称">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>字典key<span class="required" aria-required="true">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="key" value="{{$info['group_key']}}" class="form-control" data-required="true" placeholder="字典key">
                                </div>
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
