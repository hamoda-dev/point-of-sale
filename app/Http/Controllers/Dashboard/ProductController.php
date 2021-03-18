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
use Exception;

class ProductController extends Controller
{
    public function __construct()
    {
        // check permission to access methods
        $this->middleware('permission:read_products')->only('index');
        $this->middleware('permission:create_products')->only(['create', 'store']);
        $this->middleware('permission:update_products')->only(['edit', 'update']);
        $this->middleware('permission:delete_products')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {

        $products = Product::where(function ($query) use ($request) {

            // filter when request have category id
            $query->when($request->category, function ($q) use ($request) {
                return $q->where('category_id', $request->category);
            });

            // filter when request have search
            $query->when($request->search, function ($q) use ($request) {
                return $q->whereTranslation('name', $request->search);
            });

        })->latest()->paginate(12);

        $categories = Category::all();

        return view('dashboard.pages.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('dashboard.pages.products.create', compact('categories'));
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

        // save product data
        Product::create($requestData);

        session()->flash('success_message', trans('site.dataAddedSuccessfully'));

        return redirect()->route('dashboard.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  Product  $product
     * @return View
     */
    public function show(Product $product): View
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
        return view('dashboard.pages.products.edit', compact('categories','product'));
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

        // update product data
        $product->update($requestData);

        session()->flash('success_message', trans('site.dataUpdatedSuccessfully'));

        return redirect()->route('dashboard.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product $product
     * @return RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {

        try {
            // delete product
            $product->delete();

            if ($product->image !== 'product.png') {
                // delete product image
                Storage::disk('public_uploads')->delete('products_image/' . $product->image);
            }

            session()->flash('success_message', trans('site.dataDeletedSuccessfully'));
        } catch (Exception) {
            session()->flash('error_message', trans('site.dataDeletedFail'));
        }

        return redirect()->route('dashboard.products.index');
    }
}
