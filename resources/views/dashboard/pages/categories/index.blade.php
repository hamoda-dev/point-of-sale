@extends('dashboard.layouts.app')

@section('title',  trans('site.dashboard') . ' - ' . trans('site.categories'))

@section('page-head')
    @lang('site.categories')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">@lang('site.dashboard')</a></li>
    <li class="breadcrumb-item active">@lang('site.categories')</li>
@endsection

@section('content')
    <div class="card card-dark">
        <div class="card-header">
            <h4 class="mb-3">@lang('site.categories')</h4>

{{--            <form action="{{ route('dashboard.categories.index') }}" method="get" class="form-inline" style="display: inline-block">--}}
{{--                <input type="text" name="search" value="{{ request()->search }}" class="form-control" placeholder="@lang('site.search')">--}}
{{--                <button class="btn btn-info mr-1" type="submit"><i class="fa fa-search"></i> @lang('site.search')</button>--}}
{{--            </form>--}}

            @if(auth()->user()->hasPermission('create_categories'))
                <a href="{{ route('dashboard.categories.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> @lang('site.add_category')</a>
            @else
                <a href="#" class="btn btn-success disabled"><i class="fa fa-user-plus"></i> @lang('site.add_category')</a>
            @endif

        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ trans('site.name') }}</th>
                        <th>{{ trans('site.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $index => $category)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                @if(auth()->user()->hasPermission('update_categories'))
                                    <a href="{{ route('dashboard.categories.edit', $category->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                @else
                                    <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                @endif

                                @if(auth()->user()->hasPermission('delete_categories'))
                                    <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="POST" style="display: inline-block">
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

{{--    {{ $categories->links() }}--}}

@endsection
