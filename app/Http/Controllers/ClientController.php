<?php

namespace App\Http\Controllers;

use App\DataTables\ClientsDataTable;
use App\Http\Requests\Users\Admins\StoreAdminRequest;
use App\Http\Requests\Users\Admins\UpdateAdminRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:client_create')->only('create', 'store');
        $this->middleware('permission:client_read')->only('index');
        $this->middleware('permission:client_update')->only('edit', 'update');
        $this->middleware('permission:client_delete')->only('destroy');
    }

    public function index(ClientsDataTable $dataTable)
    {
        return $dataTable->render('users.clients.index');
    }

    public function create(Request $request)
    {
        return view('users.clients.create');
    }

    public function store(StoreAdminRequest $request)
    {
        $user = User::create([
                'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
                'password' => bcrypt($request->input('password'))
            ] + $request->all());

        $user->assignRole('client');

        return response()->json('Client Created Successfully', 201);
    }

    public function edit(User $client)
    {
        return view('users.clients.edit', [
            'user' => $client
        ]);
    }

    public function update(UpdateAdminRequest $request, User $client)
    {
        $client->update([
                'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
                'password' => bcrypt($request->input('password'))
            ] + $request->all());


        return response()->json('Client Update Successfully');
    }

    public function destroy(User $client)
    {
        $client->delete();

        return response()->json('Client Update Successfully');
    }
}
