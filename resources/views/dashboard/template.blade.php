@extends('dashboard.layouts.app')

@section('title', 'AdminLTE 3 | Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">{{ trans('site.dashboard') }}</a></li>
    <li class="breadcrumb-item active">Link 2</li>
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h4>{{ trans('site.dashboard') }}</h4>
        </div>
        <div class="card-body">

        </div>
    </div>
@endsection
