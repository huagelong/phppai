@extends('admin::layout/content.blade.php')
@section('content')
    <div class="row rowcontent">
        <div class="col-md-6">
            <div class="portlet light">
                <div class="portlet-body form">
                    <form method="post"  class="ajaxform"  action="@uri('admin::base@user@index/doeditpwd', ['id'=>$info['id']])">
                        <div class="form-body">
                            <div class="form-group">
                                <label>用户新密码<span class="required" aria-required="true">*</span></label>
                                <div class="input-group">
                                    <input type="password" name="newpwd" value="" class="form-control input-large" data-required="true" placeholder="用户新密码">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>操作人密码<span class="required" aria-required="true">*</span></label>
                                <div class="input-group">
                                    <input type="password" name="pwd" value=""  class="form-control input-large" data-required="true" placeholder="操作人密码">
                                </div>
                            </div>
                        </div>
                        <div class="left">
                            <button type="submit" class="btn btn-primary btn-sm">提交</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
