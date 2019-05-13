<div class="table-responsive panel-body message">
    <table class="table table-condensed table-hover">
        <thead>
        <tr>
            <th class="col-md-1">ID</th>
            <th class="col-md-3">@lang('user.title')</th>
            <th class="col-md-4">@lang('user.title_alt')</th>
            <th class="col-md-2">@lang('user.created_at')</th>
            <th class="col-md-1">@lang('user.is_active')</th>
            <th class="col-md-1">@lang('user.active')</th>
        </tr>
        </thead>
        @foreach($categories as $list)
            <div class="modal" id="myModal{{$list->id}}" data-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">×
                            </button>
                            <h4 class="modal-title">@lang('user.edit')</h4>
                        </div>
                        <div class="container"></div>
                        <div class="modal-body">
                            <form id="delete{{$list->id}}"
                                  action="{{route('category.destroy',[$list->id])}}"
                                  method="post">
                            </form>
                            <form id="update{{$list->id}}" method="POST"
                                  action="{{route('category.update',[$list->id])}}"
                                  enctype="multipart/form-data">
                            </form>
                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="exampleTextarea">@lang('user.title')</label>
                                <input form="update{{$list->id}}" name="title"
                                       class="form-control"
                                       value="{{$list->title}}"/>
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('title_alt') ? ' has-error' : '' }}">
                                <label for="exampleTextarea">@lang('user.title_alt')</label>
                                <input form="update{{$list->id}}" name="title_alt"
                                       class="form-control"
                                       value="{{$list->title_alt}}"/>
                                @if ($errors->has('title_alt'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title_alt') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('title_url') ? ' has-error' : '' }}">
                                <label for="exampleTextarea">@lang('user.title_url')</label>
                                <input form="update{{$list->id}}" name="title_url"
                                       class="form-control"
                                       value="{{$list->title_url}}"/>
                                @if ($errors->has('title_url'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title_url') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="exampleTextarea">@lang('user.description')</label>
                                <fieldset>
                                    <textarea form="update{{$list->id}}" rows="10" name="description" class="form-control">{{ $list->description or old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </fieldset>
                            </div>

                            <div class="modal-footer">
                                <a href="#" data-dismiss="modal"
                                   class="btn">@lang('user.close')</a>
                                <input form="update{{$list->id}}" type="hidden"
                                       name="_token"
                                       value="{{csrf_token()}}"/>
                                <input form="update{{$list->id}}" type="hidden"
                                       name="_method"
                                       value="put">
                                <input form="delete{{$list->id}}" type="hidden"
                                       name="_token"
                                       value="{{csrf_token()}}"/>
                                <input form="delete{{$list->id}}" type="hidden"
                                       name="_method"
                                       value="delete"/>
                                <button form="delete{{$list->id}}" type="submit"
                                        class="btn btn-danger">@lang('user.delete')</button>

                                <button form="update{{$list->id}}" type="submit"
                                        class="btn btn-primary">@lang('user.save')</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <tbody id="item-{{$list->id}}">
            <tr>
                <td>{{$list->id}}</td>
                <td>{{$list->title}}</td>
                <td>{{$list->title_alt}}</td>
                <td>{{$list->created_at->format('d.m.Y G:i:s')}}</td>
                <td>
                    @if($list->is_active == '1')
                        {{"Да"}}
                    @else
                        {{"Нет"}}
                    @endif</td>
                <td>@if($list->is_active == '0')
                        <form class="form-horizontal"
                              action="{{route('category_active',['id'=>$list->id])}}"
                              method="POST">
                            <input type="hidden" name="_method" value="put">
                            <input type="hidden" name="_token"
                                   value="{{ csrf_token() }}"/>
                            <p data-placement="top" data-toggle="tooltip" title="Активировать">
                                <button class="btn btn-primary btn-xs">
                                    <span class="glyphicon glyphicon-plus"></span></button>
                            </p>
                        </form>
                    @else
                        <form class="form-horizontal"
                              action="{{route('category_active',['id'=>$list->id])}}"
                              method="POST">
                            <input type="hidden" name="_method" value="put">
                            <input type="hidden" name="_token"
                                   value="{{ csrf_token() }}"/>
                            <p data-placement="top" data-toggle="tooltip"
                               title="Дезактивация">
                                <button class="btn btn-primary btn-xs">
                                    <span class="glyphicon glyphicon-minus"></span></button>
                            </p>
                        </form>
                    @endif
                </td>
                <td><a href="#" data-toggle="modal" data-target="#exampleModal" data-name="{{$list->title}}"
                       data-id="{{$list->id}}"
                       class="btn btn-sm pull-right">@lang('user.delete')
                    </a><a data-toggle="modal" href="#myModal{{$list->id}}"
                       class="span6 pull-right">
                        <span class="badge">@lang('user.edit')</span>
                    </a></td>
            </tr>
            </tbody>
        @endforeach
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
    {{ $categories->links() }}
</div>