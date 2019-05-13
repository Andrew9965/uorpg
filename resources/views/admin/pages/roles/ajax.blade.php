<div class="panel panel-default">
    <div class="table-responsive panel-body message">
        <table class="table table-condensed table-hover">
            <thead>
            <tr>
                <th class="span1">@lang('user.id')</th>
                <th class="span2">@lang('user.email')</th>
                <th class="span2">@lang('user.name')</th>
                <th class="span2">@lang('user.role')</th>
                <th class="span2">@lang('user.type')</th>
                <th class="span2">@lang('user.is_active_full')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $list)
                <tr>
                    <td>{{$list->id}}</td>
                    <td>{{$list->email}}</td>
                    <td>{{$list->name}}</td>
                    <td>@foreach($list->roles as $item)
                            {{$item->name}}
                            @if(!$loop->last)
                                ,
                            @endif
                        @endforeach</td>
                    <td>@if($list->is_representativ) Предствитель @else Пользователь @endif</td>
                    <td>@if($list->is_active) Активирован @else Не активирован @endif</td>
                    <td><a href="{{route('roles.show',['id'=>$list->id])}}"
                           class="pull-right">
                            <span class="badge">@lang('user.edit')</span>
                        </a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</div>