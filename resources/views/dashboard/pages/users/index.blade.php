@extends('dashboard.layouts.app')

@section('title', 'AdminLTE 3 | Dashboard')

@section('page-head')
    @lang('site.users')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">@lang('site.dashboard')</a></li>
    <li class="breadcrumb-item active">@lang('site.users')</li>
@endsection

@section('content')
    <div class="card card-dark">
        <div class="card-header">
            <h4 class="mb-3">@lang('site.users')</h4>

            <form action="" class="form-inline" style="display: inline-block">
                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')">
                <button class="btn btn-info mr-1" type="submit"><i class="fa fa-search"></i> @lang('site.search')</button>
            </form>
            <a href="{{ route('dashboard.users.create') }}" class="btn btn-success"><i class="fa fa-user-plus"></i> @lang('site.add_user')</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ trans('site.first_name') }}</th>
                        <th>{{ trans('site.last_name') }}</th>
                        <th>{{ trans('site.email') }}</th>
                        <th>{{ trans('site.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> {{ trans('site.edit') }}</a>

                                <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="POST" style="display: inline-block">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm delete-confirmation"><i class="fa fa-trash"></i> {{ trans('site.delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
