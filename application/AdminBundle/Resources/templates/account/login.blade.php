@extends('admin::layout/base.blade.php')
@section('title', '登录')
@section('page')
    <div class="page-wrapper">
        <div class="row" style="margin-top: 100px;margin-bottom: 10px;">
            <div class="col-sm-4"></div>
            <div class="col-sm-4" style="text-align: center">
                <img src="@static('/static/images/adminlogo.png')" style="width: 200px;" />
            </div>
            <div class="col-sm-4"></div>
        </div>
        <div class="row" >
            <div class="col-sm-4"></div>
            <div class="col-sm-4" style="background-color:#fff">
                <form class="ajaxform form-horizontal"  method="post" action="@uri('admin::account/login')">
                        <div class="form-group">
                            <label class=" col-sm-3">用户名</label>
                           <div class="col-sm-6">
                            <input type="text" name="username" data-required="true" class="form-control" placeholder="用户名" value="{{$loginUsername}}">
                           </div>
                        </div>
                        <div class="form-group">
                            <label  class=" col-sm-3">密码</label>
                            <div class="col-sm-6">
                            <input type="password" name="pwd" data-required="true" class="form-control" placeholder="密码">
                            </div>
                        </div>
                        <div class="form-group" id="errorId">
                            <label  class=" col-sm-3">图形验证码</label>
                            <div class="col-sm-3">
                            <input type="text" data-errorid="#errorId" data-img=".recaptcha" data-errorclass="has-error" data-checkurl="@uri('glob::captcha/checkcaptcha', ['type'=>'site_login'])" name="captcha" data-required="true" class="form-control irecaptcha" placeholder="图形验证码">
                            </div>
                                <div class="col-sm-4">
                            <img src="@uri('glob::captcha/recaptcha',['type'=>'site_login'])" style="height: 40px;" class="recaptcha"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <input type="hidden" name="goto" value="{{$goto}}">
                                <button type="submit" class="btn btn-primary">登录</button>
                            </div>
                        </div>
                </form>
            </div>
            <div class="col-sm-4"></div>
            </div>
    </div>
@endsection