@extends('dashboard.layouts.app')

@section('title', trans('site.dashboard') . ' - ' . trans('site.edit_product'))

@section('page-head')
    @lang('site.products')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">{{ trans('site.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('dashboard.products.index') }}">@lang('site.products')</a></li>
    <li class="breadcrumb-item active">@lang('site.edit_product')</li>
@endsection

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h4>@lang('site.edit_product')</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" role="form">
                @csrf
                @method('patch')
                <div class="form-group">
                    <label for="allCategories">@lang('site.categories')</label>
                    <select name="category_id" class="form-control">
                        <option value="">@lang('site.all_categories')</option>

                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>

                    @error('category_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                @foreach(config('translatable.locales') as $locale)
                    <div class="form-group">
                        <label for="{{ $locale }}Name">@lang('site.' . $locale . '.name')</label>
                        <input type="text" name="{{ $locale }}[name]" value="{{ $product->name }}" class="form-control" id="{{ $locale }}Name" placeholder="@lang('site.' . $locale . '.name')">

                        @error($locale. '.name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="{{ $locale }}Description">@lang('site.' . $locale . '.description')</label>
                        <textarea type="text" name="{{ $locale }}[description]" class="form-control" id="{{ $locale }}Description">
                            {{ $product->description }}
                        </textarea>

                        @error($locale . '.description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                @endforeach

                <div class="form-group">
                    <label for="purchasePrice">@lang('site.purchase_price')</label>
                    <input type="number" name="purchase_price" value="{{ $product->purchase_price }}" class="form-control" id="purchasePrice" placeholder="@lang('site.purchase_price')">

                    @error('purchase_price')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="salePrice">@lang('site.sale_price')</label>
                    <input type="number" name="sale_price" value="{{ $product->sale_price }}" class="form-control" id="salePrice" placeholder="@lang('site.sale_price')">

                    @error('sale_price')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="stock">@lang('site.stock')</label>
                    <input type="number" name="stock" value="{{ $product->stock }}" class="form-control" id="stock" placeholder="@lang('site.stock')">

                    @error('stock')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image">@lang('site.product_image')</label>
                    <input type="file" name="image" class="form-control" id="image" placeholder="@lang('site.product_image')">

                    @error('image')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div>
                        <img id="imagePreview" src="{{ $product->image_path }}" class="img-thumbnail mt-1" style="width: 100px">
                    </div>
                </div>

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
