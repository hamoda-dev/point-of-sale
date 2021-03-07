@extends('dashboard.layouts.app')

@section('title',  trans('site.dashboard') . ' - ' . trans('site.users'))

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

            <form action="{{ route('dashboard.users.index') }}" method="get" class="form-inline" style="display: inline-block">
                <input type="text" name="search" value="{{ request()->search }}" class="form-control" placeholder="@lang('site.search')">
                <button class="btn btn-info mr-1" type="submit"><i class="fa fa-search"></i> @lang('site.search')</button>
            </form>

            @if(auth()->user()->hasPermission('create_users'))
                <a href="{{ route('dashboard.users.create') }}" class="btn btn-success"><i class="fa fa-user-plus"></i> @lang('site.add_user')</a>
            @else
                <a href="#" class="btn btn-success disabled"><i class="fa fa-user-plus"></i> @lang('site.add_user')</a>
            @endif

        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ trans('site.first_name') }}</th>
                        <th>{{ trans('site.last_name') }}</th>
                        <th>{{ trans('site.email') }}</th>
                        <th>{{ trans('site.user_image') }}</th>
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
                            <td><img src="{{ $user->image_path }}" class="img-thumbnail" style="width: 100px"></td>
                            <td>
                                @if(auth()->user()->hasPermission('update_users'))
                                    <a href="{{ route('dashboard.users.edit', $user->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                @else
                                    <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                @endif

                                @if(auth()->user()->hasPermission('delete_users'))
                                    <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="POST" style="display: inline-block">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm delete-confirmation"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                    </form>
                                @else
                                    <a href="#" class="btn btn-danger btn-sm disabled"><i class="fa fa-trash"></i> @lang('site.delete')</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">@lang('site.data_not_found')</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $users->appends(request()->query())->links() }}

@endsection
