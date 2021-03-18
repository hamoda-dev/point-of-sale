<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;

class CategoryController extends Controller
{
    public function __construct()
    {
        // check permission to access methods
        $this->middleware('permission:read_categories')->only('index');
        $this->middleware('permission:create_categories')->only(['create', 'store']);
        $this->middleware('permission:update_categories')->only(['edit', 'update']);
        $this->middleware('permission:delete_categories')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $categories = Category::when($request->search, function ($q) use ($request) {
            return $q->whereTranslation('name', $request->search);
        })->latest()->paginate(12);

        return view('dashboard.pages.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('dashboard.pages.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        Category::create($request->all());

        session()->flash('success_message', trans('site.dataAddedSuccessfully'));

        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Category $category
     * @return View
     */
    public function edit(Category $category): View
    {
        return view('dashboard.pages.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CategoryRequest $request
     * @param  Category $category
     * @return RedirectResponse
     */
    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->all());

        session()->flash('success_message', trans('site.dataUpdatedSuccessfully'));

        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return RedirectResponse
     */
    public function destroy(Category $category): RedirectResponse
    {
        try {
            $category->delete();
            session()->flash('success_message', trans('site.dataDeletedSuccessfully'));
        } catch (Exception) {
            session()->flash('error_message', trans('site.dataDeletedFail'));
        }

        return redirect()->route('dashboard.categories.index');
    }
}
