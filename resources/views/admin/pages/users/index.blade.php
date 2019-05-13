@extends('admin.layouts.sidebar')

@section('content')

    <div class="xs-nopadding container-fluid">
        @if (session()->has('message'))
            <ul>
                <li class="alert alert-success" role="alert">{{session()->get('message')}}</li>
            </ul>
        @endif
        <script>
            window.setTimeout(function () {
                $(".alert").fadeTo(500, 0).slideUp(500, function () {
                    $(this).remove();
                });
            }, 2500);
        </script>
        @if($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="alert alert-danger">
                        {{ $error }}
                    </li>
                @endforeach
            </ul>
        @endif
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">@lang('user.add')</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('users.store')}}" method="post">

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="exampleTextarea">@lang('user.email')</label>
                                <fieldset>
                                    <input value="{{ old('email') }}" name="email" class="form-control"/>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </fieldset>
                            </div>

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="exampleTextarea">@lang('user.name')</label>
                                <fieldset>
                                    <input value="{{ old('name') }}" name="name" class="form-control"/>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </fieldset>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password">Пароль</label>

                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password-confirm">Подтвердите пароль</label>

                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation"
                                       required>
                            </div>

                            <div class="form-group{{ $errors->has('is_representative') ? ' has-error' : '' }}">
                                <label>@lang('user.is_representative')</label>
                                <select name="is_representative"
                                        class="form-control selectpicker">
                                    <option @if(old('is_representative') == '0') selected
                                            @endif value="0">Пользователь
                                    </option>
                                    <option @if(old('is_representative') == '1') selected
                                            @endif value="1">Представитель организации
                                    </option>
                                </select>
                                @if ($errors->has('is_representative'))
                                    <div class="form-error">
                                        {{ $errors->first('is_representative') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('is_active') ? ' has-error' : '' }}">
                                <label>@lang('user.activation')</label>
                                <select name="is_active"
                                        class="form-control selectpicker">
                                    <option @if(old('is_active') == '0') selected
                                            @endif value="0">Не активирован
                                    </option>
                                    <option @if(old('is_active') == '12') selected
                                            @endif value="1">Активирован
                                    </option>
                                </select>
                                @if ($errors->has('is_active'))
                                    <div class="form-error">
                                        {{ $errors->first('is_active') }}
                                    </div>
                                @endif
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
                <h4>@lang('user.users')</h4>
            </div>
            <div class="col-md-4 col-xs-12">
                <div class="form-group">
                    <button type="button" class="btn btn-info" data-toggle="modal"
                            data-target="#myModal">@lang('user.add')</button>
                </div>
            </div>
            <div class="search">
                <div class="row">
                    <div class="col-lg-10 col-lg-offset-1">
                        <div class="input-group">
                            <span class="input-group-addon"
                                  style="color: white; background-color: rgb(124,77,255);">@lang('user.find_users')</span>
                            <input type="text" autocomplete="off" id="search" class="form-control input-lg"
                                   placeholder="@lang('user.type_user_here')">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div>Сортировка:</div>
            <div class="form-group">
                <select name="sort_by" id="sort_by"
                        class="selectpicker">
                    <option @if(old('sort_by')=='id') selected @endif
                    value="id">ID
                    </option>
                    <option @if(old('sort_by')=='name') selected @endif
                    value="email">Email
                    </option>
                    <option @if(old('sort_by')=='is_representative') selected @endif
                    value="is_representative">Тип
                    </option>
                </select>
            </div>
        </div>
        <div class="col-md-12">

            <div class="posts">
                @include('admin.pages.users.ajax')
            </div>
        </div>
    </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $("#search").keyup(function () {
                var str = $("#search").val();
                if (str == "") {
                } else {
                    $.get("{{ route('users.index') }}" + '?search=' + str, function (data) {
                        $(".posts").html(data);
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            // $(document).on('click', '.pagination a', function (e) {
            //     paginateItem($(this).attr('href').split('page=')[1]);
            //     e.preventDefault();
            // });
            $('#sort_by').on('change', function () {
                paginateItem('1');
            });
        });

        $(window).on('hashchange', function () {
            if (window.location.hash) {
                var page = window.location.hash.replace('#', '');
                if (page == Number.NaN || page <= 0) {
                    return false;
                } else {
                    paginateItem(page);
                }
            }
        });


        function paginateItem(page) {
            var sort_by = $('#sort_by').val();
            console.log(sort_by);
            $.ajax({
                url: '{{route('users.index')}}?page=' + page,
                dataType: 'json',
                data: {
                    'sort_by': sort_by,
                },
            }).done(function (data) {
                $('.posts').html(data);
                $('html, body').animate({scrollTop: $('.search').offset().top}, 'fast');
                location.hash = page;
            }).fail(function (data) {
                alert('Больше нет записей.');
            });
        }

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
                url: "/admin/users/" + button.data('id'),
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