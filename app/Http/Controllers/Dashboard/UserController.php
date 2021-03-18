<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:read_users')->only('index');
        $this->middleware('permission:create_users')->only(['create', 'store']);
        $this->middleware('permission:update_users')->only(['edit', 'update']);
        $this->middleware('permission:delete_users')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $users = User::whereRoleIs('admin')->where(function ($q) use ($request) {
            return $q->when($request->search, function ($query) use ($request) {
               return $query->where('first_name', 'like', '%' . $request->search . '%')
                   ->orWhere('last_name', 'like', '%' . $request->search . '%')
                   ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        })->latest()->paginate(10);

        return view('dashboard.pages.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('dashboard.pages.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserRequest $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request): RedirectResponse
    {
        // collect needed request data
        $requestData = $request->except('password','password_confirmation', 'permissions', 'image');

        // add hashed password to request data
        $requestData['password'] = bcrypt($request->password);

        // upload user image
        if ($request->image) {
            // resize img and upload it
            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('uploads/users_image/' . $request->image->hashName()));

            // add hash image name to request data
            $requestData['image'] = $request->image->hashName();
        }

        // save user data
        $user = User::create($requestData);

        // attach admin role to user
        $user->attachRole('admin');

        // check if not empty permission then sync permission to user
        (array) $request->permissions ?? $user->syncPermissions($request->permissions);

        // flash success message
        session()->flash('success_message', trans('site.dataAddedSuccessfully'));
        return redirect()->route('dashboard.users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return View
     */
    public function edit(User $user): View
    {
        return view('dashboard.pages.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserRequest $request
     * @param  User $user
     * @return RedirectResponse
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        // collect needed request data
        $requestData = $request->only(['first_name', 'last_name', 'email']);

        // update user image
        if ($request->image) {
            // resize img and upload it
            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('uploads/users_image/' . $request->image->hashName()));

            // add hash image name
            $requestData['image'] = $request->image->hashName();

            // delete the old image
            Storage::disk('public_uploads')->delete('users_image' . $user->image);
        }

        // update user data
        $user->update($requestData);

        // sync permission to user
        $user->syncPermissions((array) $request->permissions);

        session()->flash("success_message", trans('site.dataUpdatedSuccessfully'));

        return redirect()->route('dashboard.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        try {
            // delete user
            $user->delete();

            // delete user image
            if ($user->image !== 'default.png') {
                // delete user image
                Storage::disk('public_uploads')->delete('users_image' . $user->image);
            }

            // flash success message
            session()->flash('success_message', trans('site.dataDeletedSuccessfully'));

        } catch (Exception) {

            // flash error message
            session()->flash('error_message', trans('site.dataDeletedFail'));
        }

        return redirect()->route('dashboard.users.index');
    }
}
