@extends('dashboard.layouts.app')

@section('title',  trans('site.dashboard') . ' - ' . trans('site.products'))

@section('page-head')
    @lang('site.products')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">@lang('site.dashboard')</a></li>
    <li class="breadcrumb-item active">@lang('site.products')</li>
@endsection

@section('content')
    <div class="card card-dark">
        <div class="card-header">
            <h4 class="mb-3">@lang('site.products')</h4>

            <form action="{{ route('dashboard.products.index') }}" method="get" class="form-inline" style="display: inline-block">
                <input type="text" name="search" value="{{ request()->search }}" class="form-control" placeholder="@lang('site.search')">
                <button class="btn btn-info mr-1" type="submit"><i class="fa fa-search"></i> @lang('site.search')</button>
            </form>

            @if(auth()->user()->hasPermission('create_products'))
                <a href="{{ route('dashboard.products.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> @lang('site.add_product')</a>
            @else
                <a href="#" class="btn btn-success disabled"><i class="fa fa-user-plus"></i> @lang('site.add_product')</a>
            @endif

        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('site.name')</th>
                    <th>@lang('site.product_image')</th>
                    <th>@lang('site.purchase_price')</th>
                    <th>@lang('site.sale_price')</th>
                    <th>@lang('site.profits_percent')</th>
                    <th>@lang('site.stock')</th>
                    <th>@lang('site.action')</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($products as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td>
                            <img src="{{ $product->image_path }}" class="img-thumbnail" style="width: 100px">
                        </td>
                        <td>{{ $product->purchase_price }}</td>
                        <td>{{ $product->sale_price }}</td>
                        <td>{{ $product->profits_percent }}%</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            @if(auth()->user()->hasPermission('update_products'))
                                <a href="{{ route('dashboard.products.edit', $product->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                            @else
                                <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                            @endif

                            @if(auth()->user()->hasPermission('delete_products'))
                                <form action="{{ route('dashboard.products.destroy', $product->id) }}" method="POST" style="display: inline-block">
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
                        <td colspan="7" class="text-center">@lang('site.data_not_found')</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $products->links() }}

@endsection
