<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
// use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
// use Mockery\Expectation;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $users = User::all();

        return view('dashboard.pages.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        return view('dashboard.pages.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Dashboard\UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $requestData = $request->except('password', 'password_confirmation');

        $requestData['password'] = bcrypt($request->password);

        // must refactor to try catch
        User::create($requestData);

        session()->flash('success_message', trans('site.dataAddedSuccessfly'));

        return redirect()->route('dashboard.users.index');
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\User  $user
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(User $user)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (empty($user)) {
            session()->flash('error_message', trans('site.user_not_exist'));
        }

        return view('dashboard.pages.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->only(['frist_name', 'last_name', 'email']));

        session()->flash("success_message", trans('site.dataUpdatedSuccessfly'));

        return redirect()->route('dashboard.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        // must refactor try catch
        $user->delete();

        session()->flash('success_message', trans('site.dataDeletedSuccessfly'));

        return redirect()->route('dashboard.users.index');
    }
}
