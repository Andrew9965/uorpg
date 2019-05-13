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
                        <form action="{{route('brand.store',['city' => session()->get('city_url')])}}" method="post" enctype="multipart/form-data">
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
                                <label for="exampleTextarea">Альтернативное названия</label>
                                <fieldset>
                                    <input value="{{ old('title_alt') }}" name="title_alt" class="form-control"/>
                                    @if ($errors->has('title_alt'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('title_alt') }}</strong>
                                    </span>
                                    @endif
                                </fieldset>
                            </div>
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="exampleTextarea">@lang('user.description')</label>
                                <fieldset>
                                    <textarea name="description"
                                              class="form-control">{{ old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
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
                            <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }}">
                                &nbsp;
                                <label class="btn btn-default btn-file no-results">
                                    {{trans('user.browse')}}<input type="file" class="imgInp"
                                                                   style="display: none;"
                                                                   name="logo"/>
                                </label>
                                @if ($errors->has('logo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('logo') }}</strong>
                                    </span>
                                @endif
                                <img class="img-responsive img-thumbnail" style="display: none;" id="blah"
                                     src="" alt="your image"/>
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
                <h4>@lang('user.brand')</h4>
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
                                <th class="col-md-2">Альтернативное название</th>
                                <th class="col-md-2">@lang('user.logo')</th>
                                <th class="col-md-2">@lang('user.is_active')</th>
                                <th class="col-md-2">@lang('user.active')</th>
                            </tr>
                            </thead>
                            @foreach($brands as $list)
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
                                                      action="{{route('brand.destroy',[$list->id])}}"
                                                      method="post">
                                                </form>
                                                <form id="update{{$list->id}}" method="POST"
                                                      action="{{route('brand.update',[$list->id])}}"
                                                      enctype="multipart/form-data">
                                                </form>
                                                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                                    <label for="exampleTextarea">@lang('user.title')</label>
                                                    <input form="update{{$list->id}}" name="title" id="title"
                                                           class="form-control"
                                                           value="{{$list->title}}"/>
                                                    @if ($errors->has('title'))
                                                        <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('title_alt') ? ' has-error' : '' }}">
                                                    <label for="exampleTextarea">Альтернативное названия</label>
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
                                                    <input form="update{{$list->id}}" name="title_url" id="title_url"
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
                                                    <textarea form="update{{$list->id}}" name="description"
                                                              class="form-control">{{$list->description}}</textarea>
                                                    @if ($errors->has('description'))
                                                        <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                                    @endif
                                                </div>
                                                <div class="form-group{{ $errors->has('logo') ? ' has-error' : '' }}">
                                                    &nbsp;
                                                    <label class="btn btn-default btn-file no-results">
                                                        {{trans('user.browse')}}<input form="update{{$list->id}}"
                                                                                       type="file" class="imgInp"
                                                                                       style="display: none;"
                                                                                       name="logo"/>
                                                    </label>
                                                    @if ($errors->has('logo'))
                                                        <span class="help-block">
                                        <strong>{{ $errors->first('logo') }}</strong>
                                    </span>
                                                    @endif
                                                    <img class="img-responsive img-thumbnail blah" @if($list->logo =='')
                                                    height="100px"
                                                         @endif @if($list->logo=='')style="display: none" @endif
                                                         src="{{$list->logo!=''?$list->logo:''}}" alt="your image"/>
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
                                    <td>{{$list->title}}</td>
                                    <td>{{$list->title_alt}}</td>
                                    <td><img class="img-responsive img-thumbnail"
                                             onerror="this.onerror=null;this.src='{{asset("img/no-image.png")}}';"
                                             @if(file_exists(public_path($list->logo)) && $list->logo != '')
                                             src="{{$list->logo}}"
                                             @else
                                             src="{{asset('img/no-image.png')}}"
                                             @endif
                                             alt="your image"/></td>
                                    <td class="status">
                                        @if($list->is_active == 1)
                                            {{"Да"}}
                                        @else
                                            {{"Нет"}}
                                        @endif</td>
                                    <td>@if($list->is_active == 0)
                                            <button class="btn btn-primary btn-xs activation" data-id="{{$list->id}}">
                                                        <span class="glyphicon glyphicon-plus"></span></button>
                                        @else

                                            <button class="btn btn-primary btn-xs activation" data-id="{{$list->id}}">
                                                        <span class="glyphicon glyphicon-minus"></span></button>

                                        @endif
                                    </td>
                                    <td><a href="#" data-toggle="modal" data-target="#exampleModal" data-name="{{$list->title}}"
                                           data-id="{{$list->id}}"
                                           class="btn btn-sm pull-right">@lang('user.delete')
                                        </a>
                                        <a data-toggle="modal" href="#myModal{{$list->id}}"
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
                        {{ $brands->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/jquery.translit.js')}}"></script>

    <script>
        $('input[name="title"]').translit(function (text) {
            var $title_url = $(this).parents('.modal-body').find('input[name="title_url"]');
            var string = text;
            string = string.replace(/[-]{2,}/gim, '-').replace(/\n/gim, '');
            string = string.replace(/\s+/g, '_').toLowerCase();
            $title_url.val(string);
        });


        function readURL(input, jqthis) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var img = jqthis.parents('.form-group').find('img');
                    img.attr('src', e.target.result);
                    img.attr('style', 'display:block');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(".imgInp").change(function () {
            var $jqthis = $(this);
            readURL(this, $jqthis);
        });

        $('.activation').on('click', function (e) {
            e.preventDefault();
            var button = $(this);
            $.ajax({
                url: "{{route('brand_active')}}",
                type: "PUT",
                data: {
                    _token: "{{csrf_token()}}",
                    id: button.data('id')
                },
                statusCode: {
                    500: function () {
                        console.log('Сервер недоступен');
                    }
                },
                success: function (data) {
                    if (data.status === true) {
                        button.children().removeClass('glyphicon-plus');
                        button.children().addClass('glyphicon-minus');
                        button.parent().prev().html('Да')
                    } else {
                        button.children().removeClass('glyphicon-minus');
                        button.children().addClass('glyphicon-plus');
                        button.parent().prev().html('Нет')
                    }
                },
                error: function () {
                }
            });
        })


        $(document).on('show.bs.modal', '#exampleModal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var name = button.data('name');
            var id = button.data('id');

            var modal = $(this);
            modal.find('.modal-title').text('Удалить ' + name);
            modal.find('.success-remove').data('id', id);
        });

        $(document).on('click', '.success-remove', function (e) {
            e.preventDefault();
            var button = $(this);
            $.ajax({
                url: "/admin/brand/" + button.data('id'),
                type: "DELETE",
                data: {
                    _token: "{{csrf_token()}}",
                    id: button.data('id')
                },
                statusCode: {
                    500: function () {
                        console.log('Сервер недоступен');
                    }
                },
                success: function (data) {
                    $('#item-' + button.data('id')).remove();
                    var modal = $('#exampleModal');
                    modal.find('.modal-title').text('Удалить');
                    modal.find('.success-remove').data('id', '');
                    modal.modal('toggle');
                },
                error:

                    function () {
                    }
            });
        });
    </script>
@endsection