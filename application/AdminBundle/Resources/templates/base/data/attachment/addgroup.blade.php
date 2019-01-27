@extends('admin::layout/content.blade.php')
@section('title', '文件组添加')
@section('page-bar')
    <li class="nav-tabs-header">
        <a href="@uri('admin::base@data@attachment/index')">文件管理</a>
    </li>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-body form">
                    <div class="alert alert-danger alert-dismissable">
                        注意: 添加后不能更改
                    </div>
                    <form method="post"  class="ajaxform"  action="@uri('admin::base@data@attachment/doaddgroup')">
                        <div class="form-body">
                            <div class="form-group">
                                <label>组名称<span class="required" aria-required="true">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="name" class="form-control" data-required="true" placeholder="组名称">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>组key<span class="required" aria-required="true">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="key" class="form-control" data-required="true" placeholder="组key">
                                </div>
                            </div>
                        </div>
                        <div class="left">
                            <button type="submit" class="btn btn-sm btn-info">提交</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
