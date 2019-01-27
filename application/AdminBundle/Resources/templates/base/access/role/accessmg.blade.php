@extends('admin::layout/content.blade.php')
@section('title', '权限管理')
@section('page-bar')
    <li class="nav-tabs-header">
        <a href="@uri('admin::base@access@role/index')">角色管理</a>
    </li>
@endsection
@section('content')
    <div class="row rowcontent">
        <div class="col-sm-12">
            <div class="table-toolbar">
                <div class="row">
                    <div class="col-md-6">
                       当前角色: <span class=" margin-left-10"> {{$info['name']}} </span>
                    </div>
                    <div class="col-md-offset-3 col-md-3">

                    </div>
                </div>
            </div>
                    @if($access)
                        <form class="ajaxform" action="@uri('admin::base@access@role/accessSave', ['id'=>$id])" method="post">
                            <div class="form-body">
                                <table class="table  table-bordered ">
                                    <thead>
                                    <tr class="uppercase">
                                        <th width="100px"> 类别 </th>
                                        <th width="50px"> 全选 </th>
                                        <th> 权限 </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($access as $k=>$v)
                                    <tr>
                                        <td> <span class="label label-sm label-info">{{$k}}</span> </td>
                                        <td> <input type="checkbox" class="checkall" value="{{$k}}"  /> </td>
                                        <td>
                                            @if($v)
                                                @foreach($v as $kk=>$vv)
                                                    <span class="btn btn-xs default margin-left-5 margin-bottom-5 tip"  title="{{$vv[0]}}"><input  @diff($info['access'], $vv[0], 'checked') type="checkbox" name="access[]" value="{{$vv[0]}}" /> {{$vv[1]}} </span>
                                                @endforeach
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-actions left">
                                <button type="submit" class="btn btn-sm btn-primary">保存</button>
                            </div>
                        </form>
                    </div>
                    @endif
        </div>

@endsection
@push('js')
@static('/static/bundle/admin/js/access_role_accessmg.main.js');
@endpush