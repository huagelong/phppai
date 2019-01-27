@extends('admin::layout/content.blade.php')
@section('title', '个人设置')
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="block area-block border-wrap" style="border-bottom: 1px solid #ddd">
            <div class="title">头像设置</div>
            <div class="tb">
                <dl>
                    <dd class="text-fr"><img id="myface" src="{{$userInfo['face_img'] empty '/static/images/defaultFace.jpeg'}}" /></dd>
                    <dd class="text-fl" >
                        <div class="preview-container hide">
                            <img src="{{$userInfo['face_img'] empty '/static/images/defaultFace.jpeg'}}" id="preview" />
                        </div>
                    </dd>
                </dl>
                <dl>
                    <dd class="text-fl row">
                        <div class="col-md-3">
                            <input type="file" name="upfile" id="uploadimg" >
                        </div>
                        <div class="col-md-5">
                            <form class="ajaxform col-md-offset-6" action="@uri('admin::base@user@index/crop')" method="post">
                                <input type="hidden" id="x" name="x" />
                                <input type="hidden" id="y" name="y" />
                                <input type="hidden" id="w" name="w" />
                                <input type="hidden" id="h" name="h" />
                                <input type="hidden" id="yunurl" name="yunurl" />
                                <input type="submit" value="保存" class="btn btn-primary btn-sm" />
                            </form>
                        </div>
                    </dd>
                </dl>

            </div>
        </div>
        <div class="block area-block border-wrap" style="margin-top: 10px;">
            <div class="title">安全设置</div>
            <div class="tb">
                <form class="ajaxform form-horizontal" action="@uri('admin::base@user@index/modifiPwd')" method="post">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">当前密码</label>
                        <div class=" col-sm-5">
                            <input type="password" name="oldpwd" class="form-control" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-sm-2 control-label">新密码</label>
                        <div class=" col-sm-5">
                            <input  type="password" name="pwd1" class="form-control" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">重复新密码</label>
                        <div class=" col-sm-5">
                            <input  type="password" name="pwd2" class="form-control " value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class=" col-sm-5">
                            <input type="submit" value="更改密码" class="btn btn-primary btn-sm" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
    <script>
        var upyunurl = "@uri('glob::file/upyun')";
    </script>
@static('/static/lib/jquery-ajax-file-upload/jquery.ajaxfileupload.main.js')
@static('/static/lib/Jcrop/js/jquery.Jcrop.main.js')
@static('/static/bundle/admin/js/user_setting.main.js')
@endpush