@extends('dashboard.layouts.app')

@section('title', 'AdminLTE 3 | Dashboard')

@section('page-head')
    @lang('site.clients')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">{{ trans('site.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.clients.index') }}">@lang('site.clients')</a></li>
    <li class="breadcrumb-item active">@lang('site.edit_client')</li>
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h4>@lang('site.edit_client')</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.clients.update', $client->id) }}" method="POST" enctype="multipart/form-data" role="form">
                @csrf
                @method('patch')
                @foreach(config('translatable.locales') as $locale)
                    <div class="form-group">
                        <label for="{{ $locale }}Name">@lang('site.' . $locale . '.name')</label>
                        <input type="text" name="{{ $locale . '[name]' }}" value="{{ $client->translate($locale)->name }}" class="form-control" id="{{ $locale }}Name" placeholder="@lang('site.'. $locale . '.name')">

                        @error($locale . '.name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="{{ $locale }}Name">@lang('site.' . $locale . '.address')</label>
                        <input type="text" name="{{ $locale . '[address]' }}" value="{{ $client->translate($locale)->address }}" class="form-control" id="{{ $locale }}Address" placeholder="@lang('site.'. $locale . '.address')">

                        @error($locale . '.address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach

                <div class="form-group">
                    <label for="phone">@lang('site.phone')</label>
                    <input type="number" name="phone" value="{{ $client->phone }}" class="form-control" id="phone" placeholder="@lang('site.phone')">

                    @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('site.save_data')</button>
            </form>
        </div>
    </div>
@endsection

