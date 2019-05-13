@extends('admin.layouts.sidebar')

@section('content')
    <div class="xs-nopadding container-fluid">
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Добавить новый</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('category.store',['city' => session()->get('city_url')])}}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="is_active" value="0"/>
                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="exampleTextarea">@lang('user.title')</label>
                                <fieldset>
                                    <input value="{{ old('title') }}" name="title" class="form-control"/>
                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </fieldset>
                            </div>
                            <div class="form-group{{ $errors->has('title_alt') ? ' has-error' : '' }}">
                                <label for="exampleTextarea">@lang('user.title_alt')</label>
                                <fieldset>
                                    <input value="{{ old('title_alt') }}" name="title_alt" class="form-control"/>
                                    @if ($errors->has('title_alt'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('title_alt') }}</strong>
                                    </span>
                                    @endif
                                </fieldset>
                            </div>
                            <div class="form-group{{ $errors->has('title_url') ? ' has-error' : '' }}">
                                <label for="exampleTextarea">@lang('user.title_url')</label>
                                <fieldset>
                                    <input value="{{ old('title_url') }}" name="title_url" class="form-control"/>
                                    @if ($errors->has('title_url'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('title_url') }}</strong>
                                    </span>
                                    @endif
                                </fieldset>
                            </div>
                            <div class="form-group{{ $errors->has('subsubcategory_id') ? ' has-error' : '' }}">
                                <fieldset>
                                    <label for="exampleTextarea">@lang('user.category')</label>
                                    <select class="selectpicker" name="subsubcategory_id" data-live-search="true"
                                            data-size="10" data-width="auto">
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->title}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('subsubcategory_id'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('subsubcategory_id') }}</strong>
                                    </span>
                                    @endif
                                </fieldset>
                            </div>
                            <div class="form-group{{ $errors->has('is_active') ? ' has-error' : '' }}">
                                <fieldset>
                                    <label for="exampleTextarea">@lang('user.active')</label>
                                    <input name="is_active" type="checkbox" value="1">
                                    @if ($errors->has('is_active'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('is_active') }}</strong>
                                    </span>
                                    @endif
                                </fieldset>
                            </div>
                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default"
                                        data-dismiss="modal">@lang('user.close')</button>
                                <button type="submit" class="btn btn-primary">@lang('user.save')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-xs-12">
                <h4>@lang('user.category') (4-уровень)</h4>
            </div>
            <div class="col-md-4 col-xs-12">
                <div class="form-group">
                    <button type="button" class="btn btn-info" data-toggle="modal"
                            data-target="#myModal">@lang('user.add')</button>
                </div>
            </div>
            @if($errors->any())
                <div class="registration-form-errors-container">
                    @foreach ($errors->all() as $error)
                        <div class="registration-form-error-item">
                            {{ $error }}
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="table-responsive panel-body message">
                        <table class="table table-condensed table-hover">
                            <thead>
                            <tr>
                                <th class="col-md-2">@lang('user.title')</th>
                                <th class="col-md-2">@lang('user.title_alt')</th>
                                <th class="col-md-2">@lang('user.is_active')</th>
                                <th class="col-md-2">@lang('user.active')</th>
                            </tr>
                            </thead>
                            @foreach($subcategories as $list)
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
                                                      action="{{route('category.destroy',['city' => session()->get('city_url'), $list->id])}}"
                                                      method="post">
                                                </form>
                                                <form id="update{{$list->id}}" method="POST"
                                                      action="{{route('category.update',['city' => session()->get('city_url'), $list->id])}}"
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
                                                <div class="form-group{{ $errors->has('subsubcategory_id') ? ' has-error' : '' }}">
                                                    <label for="exampleTextarea">@lang('user.category')</label>
                                                    <fieldset>
                                                        <select form="update{{$list->id}}" class="selectpicker"
                                                                name="subsubcategory_id"
                                                                data-live-search="true" data-size="10">
                                                            @foreach($categories as $category)
                                                                <option value="{{$category->id}}"
                                                                        @if($list->type_id == $category->id) selected @endif>{{$category->title}}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('subsubcategory_id'))
                                                            <span class="help-block">
                                        <strong>{{ $errors->first('subsubcategory_id') }}</strong>
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
                                <tbody>
                                <tr>
                                    <td>{{$list->title}}</td>
                                    <td>{{$list->title_alt}}</td>
                                    <td>
                                        @if($list->is_active == 1)
                                            {{"Да"}}
                                        @else
                                            {{"Нет"}}
                                        @endif</td>
                                    <td>@if($list->is_active == 0)
                                            <form class="form-horizontal"
                                                  action="{{route('subsubsubsubcategory_active',['city' => session()->get('city_url'), $list->id])}}"
                                                  method="POST">
                                                <input type="hidden" name="_method" value="put">
                                                <input type="hidden" name="_token"
                                                       value="{{ csrf_token() }}"/>
                                                <p data-placement="top" data-toggle="tooltip" title="Активировать">
                                                    <button id="active" name="is_active"
                                                            value="{{$list->id}}"
                                                            class="btn btn-primary btn-xs">
                                                        <span class="glyphicon glyphicon-plus"></span></button>
                                                </p>
                                            </form>
                                        @else
                                            <form class="form-horizontal"
                                                  action="{{route('subsubsubsubcategory_active',['city' => session()->get('city_url'), $list->id])}}"
                                                  method="POST">
                                                <input type="hidden" name="_method" value="put">
                                                <input type="hidden" name="_token"
                                                       value="{{ csrf_token() }}"/>
                                                <p data-placement="top" data-toggle="tooltip"
                                                   title="Дезактивация">
                                                    <button id="un_active" name="is_active"
                                                            value="{{$list->id}}"
                                                            class="btn btn-primary btn-xs">
                                                        <span class="glyphicon glyphicon-minus"></span></button>
                                                </p>
                                            </form>
                                        @endif
                                    </td>
                                    <td><a data-toggle="modal" href="#myModal{{$list->id}}"
                                           class="span6 pull-right">
                                            <span class="badge">@lang('user.edit')</span>
                                        </a></td>
                                </tr>
                                </tbody>
                            @endforeach
                        </table>
                        {{ $subcategories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection