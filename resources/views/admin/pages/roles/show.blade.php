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
        <form action="{{route('roles.update',['id' => $data->id])}}" method="POST">
            <input type="hidden" name="_method" value="PUT">
            {{csrf_field()}}
            <div class="form-group{{ $errors->has('email') ? ' error' : '' }}">
                <label>@lang('user.email')</label>
                <input disabled
                       class="form-control"
                       value="{{$data->email or old('email')}}"/>
                @if ($errors->has('email'))
                    <div class="form-error">{{ $errors->first('email') }}</div>
                @endif
            </div>

            <div class="form-group{{ $errors->has('name') ? ' error' : '' }}">
                <label>@lang('user.name')</label>
                <input disabled
                       class="form-control"
                       value="{{$data->name or old('name')}}"/>
                @if ($errors->has('name'))
                    <div class="form-error">{{ $errors->first('name') }}</div>
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

            <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                <label>@lang('user.roles')</label>
                <select name="role[]"
                        class="form-control selectpicker" multiple>
                    @foreach($roles as $item)
                        <option @if($data->roles->contains($item->id)) selected
                                @endif value="{{$item->id}}">{{$item->name}}
                        </option>
                    @endforeach

                </select>
                @if ($errors->has('role'))
                    <div class="form-error">
                        {{ $errors->first('role') }}
                    </div>
                @endif
            </div>

            <div class="form-group">
                <button type="submit"
                        class="btn btn-success">@lang('user.save')</button>
                <a href="{{route('roles.index')}}" class="btn btn-default">@lang('user.back')</a>
            </div>
        </form>

    </div>

@endsection

@section('script')

@endsection