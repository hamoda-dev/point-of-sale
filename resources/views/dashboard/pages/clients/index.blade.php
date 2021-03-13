@extends('dashboard.layouts.app')

@section('title',  trans('site.dashboard') . ' - ' . trans('site.clients'))

@section('page-head')
    @lang('site.clients')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">@lang('site.dashboard')</a></li>
    <li class="breadcrumb-item active">@lang('site.clients')</li>
@endsection

@section('content')
    <div class="card card-dark">
        <div class="card-header">
            <h4 class="mb-3">@lang('site.clients')</h4>

            <form action="{{ route('dashboard.clients.index') }}" method="get" class="form-inline" style="display: inline-block">
                <input type="text" name="search" value="{{ request()->search }}" class="form-control" placeholder="@lang('site.search')">
                <button class="btn btn-info mr-1" type="submit"><i class="fa fa-search"></i> @lang('site.search')</button>
            </form>

            @if(auth()->user()->hasPermission('create_clients'))
                <a href="{{ route('dashboard.clients.create') }}" class="btn btn-success"><i class="fa fa-user-plus"></i> @lang('site.add_client')</a>
            @else
                <a href="#" class="btn btn-success disabled"><i class="fa fa-user-plus"></i> @lang('site.add_client')</a>
            @endif

        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('site.name') }}</th>
                    <th>{{ trans('site.phone') }}</th>
                    <th>{{ trans('site.address') }}</th>
                    <th>{{ trans('site.action') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($clients as $index => $client)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $client->name }}</td>
                        <td>{{ $client->phone }}</td>
                        <td>{{ $client->address }}</td>
                        <td>
                            @if(auth()->user()->hasPermission('update_clients'))
                                <a href="{{ route('dashboard.clients.edit', $client->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                            @else
                                <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                            @endif

                            @if(auth()->user()->hasPermission('delete_clients'))
                                <form action="{{ route('dashboard.clients.destroy', $client->id) }}" method="POST" style="display: inline-block">
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

    {{ $clients->appends(request()->query())->links() }}

@endsection
