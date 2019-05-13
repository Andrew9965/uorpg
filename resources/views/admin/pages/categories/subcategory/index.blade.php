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
                        <form action="{{route('sub_category.store')}}" method="post" enctype="multipart/form-data">
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

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="exampleTextarea">@lang('user.description')</label>
                                <fieldset>
                                    <textarea rows="10" name="description" class="form-control">{{old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </fieldset>
                            </div>


                            <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                                <fieldset>
                                    <label for="exampleTextarea">@lang('user.category')</label>
                                    <select class="selectpicker" name="category_id" data-live-search="true"
                                            data-size="10" data-width="auto">
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->title}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('category_id'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('category_id') }}</strong>
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
                <h4>@lang('user.category') (2-уровень)</h4>
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
                                  style="color: white; background-color: rgb(124,77,255);">Найти категорию (2 уровень)</span>
                            <input type="text" autocomplete="off" id="search" class="form-control input-lg"
                                   placeholder="Начните вводить названия">
                        </div>
                    </div>
                </div>
            </div>
            <!-- search box container ends  -->
            <div id="txtHint" class="title-color" style="padding-top:50px; text-align:center;">
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

            <div class="col-md-4">
                <div>Сортировка:</div>
                <div class="form-group">
                    <select name="sort_by" id="sort_by"
                            class="selectpicker">
                        <option @if(old('sort_by')=='id') selected @endif
                        value="id">ID
                        </option>
                        <option @if(old('sort_by')=='title') selected @endif
                        value="title">Название
                        </option>
                        <option @if(old('sort_by')=='created_at') selected @endif
                        value="created_at">Дата
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="posts">
                        @include('admin.pages.categories.subcategory.ajax')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/jquery.translit.js')}}"></script>

    <script>
        $(document).ready(function () {
            $("#search").keyup(function () {
                var str = $("#search").val();
                if (str == "") {
                } else {
                    $.get("{{ route('sub_category.index') }}" + '?search=' + str, function (data) {
                        $(".posts").html(data);
                    });
                }
            });
        });
    </script>
    <script>
        $('input[name="title"]').translit(function (text) {
            var string = text;
            string = string.replace(/[-]{2,}/gim, '-').replace(/\n/gim, '');
            string = string.replace(/\s+/g, '_').toLowerCase();
            $('input[name="title_url"]').val(string);        });


        $(document).ready(function () {
            InitAjax();
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
                console.log(page);
                if (page == Number.NaN || page <= 0) {
                    return false;
                } else {
                    paginateItem(page);
                }
            }
        });

        function paginateItem(page) {
            var sort_by = $('#sort_by').val();
            $.ajax({
                url: '{{route('sub_category.index')}}?page=' + page,
                dataType: 'json',
                data: {
                    'sort_by': sort_by,
                },
            }).done(function (data) {
                $('.posts').html(data);
                $('html, body').animate({scrollTop: $('.row').offset().top}, 'fast');
                InitAjax();
                location.hash = page;
            }).fail(function () {
                alert('Больше нет записей.');
            });
        }

        function InitAjax() {
            $('.selectpicker').selectpicker('refresh');
            $('.btn-xs').on('click', function (e) {
                e.preventDefault();
                var button = $(this);
                button.find('span').removeClass('glyphicon-minus');
                button.find('span').removeClass('glyphicon-plus');
                var form = $(this).parents('form');
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function (data) {
                        if (data.status) {
                            button.find('span').addClass('glyphicon-minus');
                            button.parents('td').prev().html('Да');
                        }
                        else {
                            button.find('span').addClass('glyphicon-plus');
                            button.parents('td').prev().html('Нет');

                        }
                    },
                    error: function (data) {
                    }
                });
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
                url: "/admin/sub_category/" + button.data('id'),
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