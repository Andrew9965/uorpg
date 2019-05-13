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
        <div class="row">
            <div class="col-md-8 col-xs-12">
                <h4>@lang('user.roles')</h4>
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
                    <option @if(old('sort_by')=='roles') selected @endif
                    value="roles">Есть роль
                    </option>
                </select>
            </div>
        </div>
        <div class="col-md-12">

            <div class="posts">
                @include('admin.pages.roles.ajax')
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
                    $.get("{{ route('roles.index') }}" + '?search=' + str, function (data) {
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
                url: '{{route('roles.index')}}?page=' + page,
                dataType: 'json',
                data: {
                    'sort_by': sort_by,
                },
            }).done(function (data) {
                console.log(data);
                $('.posts').html(data);
                $('html, body').animate({scrollTop: $('.search').offset().top}, 'fast');
                location.hash = page;
            }).fail(function (data) {
                alert('Больше нет записей.');
            });
        }


    </script>
@endsection