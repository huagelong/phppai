@extends('admin::layout/default.blade.php')
@section('title', '首页')
@section('content')
    <div class="content">
        <div class="dex_list">

            <h2 style=" font-size: 22px; padding: 0 0 10px 30px;">数据列表：</h2>
            <ul class="col-sm-12 dex_list_box">
                <li class="col-sm-3">
                    <div class="dex_item">
                        <div class="dex_inner">
                            <h3>0</h3>
                            <p>xxxxx</p>
                        </div>
                    </div>
                </li>
                <li class="col-sm-3">
                    <div class="dex_item" style="">
                        <div class="dex_inner">
                            <h3>0</h3>
                            <p>xxx</p>
                        </div>
                    </div>
                </li>
                <li class="col-sm-3">
                    <div class="dex_item" style="">
                        <div class="dex_inner">
                            <h3>{{$users_count}}</h3>
                            <p>会员总数</p>
                        </div>
                    </div>
                </li>
                <li class="col-sm-3">
                    <div class="dex_item" style="">
                        <div class="dex_inner">
                            <h3>{{$today_users}}</h3>
                            <p>今日新增会员</p>
                        </div>
                    </div>
                </li>

            </ul>

        </div>
    </div>
@endsection

@push('css')
<style>
    *{margin: 0;padding: 0;}
    .dex_list{padding: 20px 0;}
    .dex_list_box>li{padding: 0 15px;margin-bottom: 20px;border-radius: 2px;position: relative;list-style: none;}
    .dex_item{background-color: #00c0ef;}
    .dex_list_box li:nth-of-type(1) .dex_item{background: #00c0ef;}
    .dex_list_box li:nth-of-type(2) .dex_item{background: #00a65a;}
    .dex_list_box li:nth-of-type(3) .dex_item{background: #f39c12;}
    .dex_list_box li:nth-of-type(4) .dex_item{background: #dd4b39;}
    .dex_inner{padding: 10px;height: 100px;color: #fff;}
    .dex_inner h3 {font-size: 32px;font-weight: bold; margin: 0 0 10px 0;padding: 0;}
    .dex_inner p {font-size: 15px;}
    .dex_a{ text-align: center;padding: 3px 0;color: #fff;color: rgba(255,255,255,0.8);display: block;background: rgba(0,0,0,0.1);}
    .dex_a:hover{color: rgba(255,255,255,1);}


    .index_msg{height: 200px;padding: 0 0 0 0px;background: url(/static/images/admin_note.png) 450px 0 no-repeat;background-size: auto 200px;}


</style>
@endpush

