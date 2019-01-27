@extends('admin::layout/content.blade.php')
@section('title', '添加字典数据')
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
                    <form method="post"  class="ajaxform"  action="@uri('admin::base@data@map/doaddoption',['groupid'=>$groupid])">
                        <div class="form-body">
                            <div class="form-group">
                                <label>数据名称<span class="required" aria-required="true">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="name" class="form-control" data-required="true" placeholder="数据名称">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>数据key<span class="required" aria-required="true">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="key" class="form-control" data-required="true" placeholder="数据key">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>数据value<span class="required" aria-required="true">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="value" class="form-control" data-required="true" placeholder="数据value">
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
