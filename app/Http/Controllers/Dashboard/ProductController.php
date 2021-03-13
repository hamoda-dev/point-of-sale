<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $products = Product::paginate(12);

        return view(view: 'dashboard.pages.products.index', data: compact(var_name: 'products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $categories = Category::all();
        return view(view: 'dashboard.pages.products.create', data: compact(var_name: 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductRequest  $request
     * @return RedirectResponse
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        $requestData = $request->all();

        if ($request->image) {
            // resize img and upload it
            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('uploads/products_image/' . $request->image->hashName()));

            // add hash image name
            $requestData['image'] = $request->image->hashName();
        }

        // must refactor to try catch
        // save user data
        $user = Product::create($requestData);

        session()->flash('success_message', trans('site.dataAddedSuccessfully'));

        return redirect()->route('dashboard.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Product $product
     * @return View
     */
    public function edit(Product $product): View
    {
        $categories = Category::all();
        return view(view: 'dashboard.pages.products.edit', data: compact('categories','product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProductRequest $request
     * @param  Product  $product
     * @return RedirectResponse
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $requestData = $request->all();

        if ($request->image) {
            // resize img and upload it
            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('uploads/products_image/' . $request->image->hashName()));

            // add hash image name
            $requestData['image'] = $request->image->hashName();
        }

        // must refactor to try catch
        // save user data
        $product->update($requestData);

        session()->flash('success_message', trans('site.dataUpdatedSuccessfully'));

        return redirect()->route('dashboard.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product  $product
     * @return RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image !== 'product.png') {
            // delete user image
            Storage::disk('public_uploads')->delete('products_image/' . $product->image);
        }

        // delete user
        $product->delete();

        session()->flash('success_message', trans('site.dataDeletedSuccessfully'));

        return redirect()->route('dashboard.products.index');

    }
}
