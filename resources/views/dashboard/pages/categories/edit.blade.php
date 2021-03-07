@extends('dashboard.layouts.app')

@section('title', 'AdminLTE 3 | Dashboard')

@section('page-head')
    @lang('site.categories')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">{{ trans('site.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index') }}">@lang('site.categories')</a></li>
    <li class="breadcrumb-item active">@lang('site.edit_category')</li>
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h4>@lang('site.edit_category')</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" role="form">
                @csrf
                @method('patch')
                @foreach(config('translatable.locales') as $locale)
                    <div class="form-group">
                        <label for="{{ $locale }}Name">@lang('site.' . $locale . '.name')</label>
                        <input type="text" name="{{ $locale . '[name]' }}" value="{{ $category->translate($locale)->name }}" class="form-control" id="{{ $locale }}Name" placeholder="@lang('site.'. $locale . '.name')">

                        @error($locale . '.name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach

                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('site.save_data')</button>
            </form>
        </div>
    </div>
@endsection

