@extends('admin.layouts.sidebar')

@section('content')
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
    <div class="col-md-8 col-sm-10 col-xs-12">
        <form action="{{route('users.update',['id' => $data->id])}}" method="POST">
            <input type="hidden" name="_method" value="PUT">
            {{csrf_field()}}
            <div class="form-group{{ $errors->has('email') ? ' error' : '' }}">
                <label>@lang('user.email')</label>
                <input name="email"
                       class="form-control"
                       value="{{$data->email or old('email')}}"/>
                @if ($errors->has('email'))
                    <div class="form-error">{{ $errors->first('email') }}</div>
                @endif
            </div>

            <div class="form-group{{ $errors->has('name') ? ' error' : '' }}">
                <label>@lang('user.name')</label>
                <input name="name"
                       class="form-control"
                       value="{{$data->name or old('name')}}"/>
                @if ($errors->has('name'))
                    <div class="form-error">{{ $errors->first('name') }}</div>
                @endif
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

                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                       required>
            </div>

            <div class="form-group{{ $errors->has('is_representative') ? ' has-error' : '' }}">
                <label>@lang('user.is_representative')</label>
                <select name="is_representative"
                        class="form-control selectpicker">
                    <option @if($data->is_representative == '0') selected
                            @endif value="0">Пользователь
                    </option>
                    <option @if($data->is_representative == '1') selected
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
                    <option @if($data->is_active == '0') selected
                            @endif value="0">Не активирован
                    </option>
                    <option @if($data->is_active == '1') selected
                            @endif value="1">Активирован
                    </option>
                </select>
                @if ($errors->has('is_active'))
                    <div class="form-error">
                        {{ $errors->first('is_active') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <button type="submit"
                        class="btn btn-success">@lang('user.save')</button>
                <a href="#" onclick="event.preventDefault();
                                                     document.getElementById('delete-form').submit();"
                   class="btn btn-danger">@lang('user.delete')</a>
                <a href="{{route('users.index')}}" class="btn btn-default">@lang('user.back')</a>

            </div>
        </form>
        <form id="delete-form" action="{{route('users.destroy',[$data->id])}}"
              method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token"
                   value="{{csrf_token()}}"/>
            <input type="hidden" name="_method"
                   value="delete"/>
        </form>
    </div>

@endsection

@section('script')

@endsection