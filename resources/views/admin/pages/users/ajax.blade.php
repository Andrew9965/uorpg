<div class="panel panel-default">
    <div class="table-responsive panel-body message">
        <table class="table table-condensed table-hover">
            <thead>
            <tr>
                <th class="span1">@lang('user.id')</th>
                <th class="span2">@lang('user.email')</th>
                <th class="span2">@lang('user.name')</th>
                <th class="span2">@lang('user.type')</th>
                <th class="span2">@lang('user.is_active_full')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $list)
                <tr id="item-{{$list->id}}">
                    <td>{{$list->id}}</td>
                    <td>{{$list->email}}</td>
                    <td>{{$list->name}}</td>
                    <td>@if($list->is_representativ) Предствитель @else Пользователь @endif</td>
                    <td>@if($list->is_active) Активирован @else Не активирован @endif</td>
                    <td><a href="#" data-toggle="modal" data-target="#exampleModal" data-name="{{$list->title}}"
                           data-id="{{$list->id}}"
                           class="btn btn-sm pull-right">@lang('user.delete')
                        </a><a href="{{route('users.show',['id'=>$list->id])}}"
                           class="pull-right">
                            <span class="badge">@lang('user.edit')</span>
                        </a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel">Удалить</h3>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                        <button type="button" class="btn btn-primary success-remove">Удалить</button>
                    </div>
                </div>
            </div>
        </div>
        {{ $users->links() }}
    </div>
</div>