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
            <form action="{{ route('dashboard.users.update', $user->id) }}" method="POST" role="form">
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

                {{-- <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div> --}}

                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('site.save_data')</button>
            </form>
        </div>
    </div>
@endsection
