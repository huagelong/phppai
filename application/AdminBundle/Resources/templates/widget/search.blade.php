<form class="form-inline" role="form" method="get">
    <div class="form-group search-dropdown">
        <div class="input-group input-medium">
            <div class="input-group-btn">
                <button type="button" class="btn btn-default dropdown-toggle btn-search" data-toggle="dropdown" aria-expanded="false"> 字段 <i class="fa fa-angle-down"></i></button>
                <ul class="dropdown-menu">
                    @if($fields)
                        @foreach($fields as $k=>$v)
                    <li>
                        <a data-field="{{$k}}" href="javascript:;"> {{$v}} </a>
                    </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <input type="text" name="searchValue" value="{{$searchValue}}" class="search-value form-control input-medium" placeholder="{{$placeholder}}">
            <span class="input-group-btn">
                                          <input type="hidden" class="searchField" name="searchField" value="{{$searchField}}">
                                          <button class="btn btn-default btn-search" type="submit">搜索</button>
                                     </span>
        </div>
    </div>
</form>