<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ClientRequest;
use App\Models\Client;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $clients = Client::paginate(12);

        return view('dashboard.pages.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('dashboard.pages.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClientRequest $request
     * @return RedirectResponse
     */
    public function store(ClientRequest $request): RedirectResponse
    {
        Client::create($request->all());

        session()->flash('success_message', trans('site.dataAddedSuccessfully'));

        return redirect()->route('dashboard.clients.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Client  $client
     * @return View
     */
    public function edit(Client $client): View
    {
        return view('dashboard.pages.clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClientRequest $request
     * @param  Client $client
     * @return RedirectResponse
     */
    public function update(ClientRequest $request, Client $client): RedirectResponse
    {
        $client->update($request->all());

        session()->flash('success_message', trans('site.dataUpdatedSuccessfully'));

        return redirect()->route('dashboard.clients.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Client  $client
     * @return RedirectResponse
     */
    public function destroy(Client $client): RedirectResponse
    {
        $client->delete();

        session()->flash('success_message', trans('site.dataDeletedSuccessfully'));

        return redirect()->route('dashboard.clients.index');
    }
}
