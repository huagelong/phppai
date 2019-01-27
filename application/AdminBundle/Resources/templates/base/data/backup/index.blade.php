@extends('admin::layout/content.blade.php')
@section('title', '数据库备份')
@section('content')
    <div class="row rowcontent">
        <div class="col-sm-12">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="@uri('admin::base@data@backup/index')">备份</a>
                        </li>
                        <li class="">
                            <a href="@uri('admin::base@data@backup/restore')">还原</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <form class="tab-pane active ajaxform" action="@uri('admin::base@data@backup/backup')" method="post">

                            <div class="row padding-bottom-10 padding-top-10">
                                <div class="col-md-5">
                                    @can("admin::base@data@backup/backup")
                                    <button type="submit" class="btn btn-sm btn-info">立即备份 <li class="fa fa-cloud-download"></li></button>
                                    @endcan()
                                </div>
                                <div class="col-md-offset-2 col-md-5">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover  table-bordered" width="100%">
                                        <thead>
                                        <tr>
                                            <th width="50px" class="text-center">
                                                <input type="checkbox" id="selectalltable">
                                            </th>
                                            <th width="300px">表名</th>
                                            <th width="100px">行数</th>
                                            <th width="100px">大小</th>
                                            <th width="100px">冗余</th>
                                            <th width="100px">字符编码</th>
                                            <th width="200px">备注</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($tables)
                                            @foreach($tables as $v)
                                        <tr>
                                            <td  class="text-center">
                                                <input type="checkbox" name="selecttable[]" value="{{$v['Name']}}">
                                            </td>
                                            <td>
                                                {{$v['Name']}}
                                            </td>
                                            <td>
                                                {{$v['Rows']}}
                                            </td>
                                            <td>
                                                {{number_format($v['Data_length']/1024, 2)}}kb
                                            </td>
                                            <td>
                                                {{$v['Data_free']}}b
                                            </td>
                                            <td>
                                                {{$v['Collation']}}
                                            </td>
                                            <td>
                                                {{$v['Comment']}}
                                            </td>
                                        </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </form>
                    </div>
        </div>
    </div>
@endsection
@push('js')
@static('/static/assets/bundle/admin/js/data_backup_index.main.js')
@endpush