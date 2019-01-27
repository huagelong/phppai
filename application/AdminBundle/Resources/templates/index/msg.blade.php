@extends('admin::layout/content.blade.php')
@section('title', '消息提醒')
@section('content')
    @if($flashMsg)
            <div class="alert alert-{{$flashMsg['type']}}">
                <p style="text-align: center">{{$flashMsg['value']}}</p>
            </div>
        <div style="float: right">
            <a href="@uri('admin::account/logout')" class="btn btn-sm btn-primary">退出</a>
        </div>
    @endif
@endsection