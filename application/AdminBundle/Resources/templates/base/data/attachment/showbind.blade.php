<div class="table-scrollable table-scrollable-borderless">
    <table class="table table-hover table-light">
        <thead>
        <tr class="uppercase">
            <th> # </th>
            <th> 绑定类型 </th>
            <th> 绑定内容 </th>
            <th> 绑定时间 </th>
        </tr>
        </thead>
        @if($info['used'])
            <tbody>
            @foreach($info['used'] as $v)
            <tr>
                <td> {{$v['id']}} </td>
                <td> {{$v['target_type']}} </td>
                <td> {{$v['target_id']}} </td>
                <td> {{$v['created_at']}} </td>
            </tr>
            @endforeach
            </tbody>
        @endif
    </table>
</div>