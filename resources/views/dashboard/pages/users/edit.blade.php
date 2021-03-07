@extends('dashboard.layouts.app')

@section('title', 'AdminLTE 3 | Dashboard')

@section('page-head')
    @lang('site.users')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">{{ trans('site.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.users.index') }}">@lang('site.users')</a></li>
    <li class="breadcrumb-item active">@lang('site.edit_user')</li>
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h4>@lang('site.edit_user')</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" role="form">
                @csrf
                @method('patch')
                <div class="form-group">
                    <label for="firstName">@lang('site.first_name')</label>
                    <input type="text" name="first_name" value="{{ $user->first_name }}" class="form-control" id="firstName" placeholder="@lang('site.first_name')">

                    @error('first_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="lastName">@lang('site.last_name')</label>
                    <input type="text" name="last_name" value="{{ $user->last_name }}" class="form-control" id="lastName" placeholder="@lang('site.last_name')">

                    @error('last_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">@lang('site.email')</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control" id="email" placeholder="@lang('site.email')">

                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image">@lang('site.user_image')</label>
                    <input type="file" name="image" value="{{ old('image') }}" class="form-control" id="image" placeholder="@lang('site.user_image')">

                    @error('image')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div>
                        <img id="imagePreview" src="{{ $user->image_path }}" class="img-thumbnail mt-1" style="width: 100px">
                    </div>
                </div>

                <!-- Permissions -->
                @php
                    $models = config('app.models');
                    $actions = ['create', 'read', 'update', 'delete'];
                @endphp
                <div class="card">
                    <div class="card-header d-flex p-0">
                        <ul class="nav nav-pills p-2">
                            @foreach($models as $index => $model)
                                <li class="nav-item"><a class="nav-link {{ $index == 0 ? 'active' : '' }}" href="#{{$model}}" data-toggle="tab">@lang('site.' . $model)</a></li>
                            @endforeach
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            @foreach($models as $index => $model)
                                <div class="tab-pane {{ $index == 0 ? 'active' : '' }}" id="{{ $model }}">
                                    @foreach($actions as $action)
                                        <label><input type="checkbox" {{ $user->hasPermission($action . '_' . $model) ? 'checked' : '' }} name="permissions[]" value="{{ $action }}_{{ $model }}"> @lang('site.' . $action)</label>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- Permission -->


                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('site.save_data')</button>
            </form>
        </div>
    </div>
@endsection

@section('extra-js')
    <script>
        $("#image").change(function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result);
                }

                reader.readAsDataURL(this.files[0]); // convert to base64 string
            }
        });
    </script>
@endsection
