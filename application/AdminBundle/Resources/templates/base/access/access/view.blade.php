@extends('admin::layout/content.blade.php')
@section('title', '权限查看')
@section('content')
    <div class="row">
        <div class="col-sm-12">
                    @if($access)
                    <div class="table-scrollable">
                        <table class="table  table-bordered ">
                            <thead>
                            <tr class="uppercase">
                                <th> 类别 </th>
                                <th> 权限 </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($access as $k=>$v)
                            <tr>
                                <td> <span class="label label-sm label-info">{{$k}}</span> </td>
                                <td>
                                    @if($v)
                                        @foreach($v as $kk=>$vv)
                                            <span class="btn btn-default btn-xs margin-left-5 margin-bottom-5 tip" title="{{$vv[0]}}"> {{$vv[1]}} </span>
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
        </div>
    </div>
@endsection
