<?php

namespace App\Http\Controllers;

use App\DataTables\AdminsDataTable;
use App\Http\Requests\Users\Admins\StoreAdminRequest;
use App\Http\Requests\Users\Admins\UpdateAdminRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:admin_create')->only('create', 'store');
        $this->middleware('permission:admin_read')->only('index');
        $this->middleware('permission:admin_update')->only('edit', 'update');
        $this->middleware('permission:admin_delete')->only('destroy');
    }

    public function index(AdminsDataTable $dataTable)
    {
        return $dataTable->render('users.admins.index');
    }

    public function create(Request $request)
    {
        return view('users.admins.create');
    }

    public function store(StoreAdminRequest $request)
    {
        $user = User::create([
                'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
                'password' => bcrypt($request->input('password'))
            ] + $request->all());

        $user->assignRole('admin');

        return response()->json('Admin Created Successfully', 201);
    }

    public function edit(User $admin)
    {
        return view('users.admins.edit', [
            'user' => $admin
        ]);
    }

    public function update(UpdateAdminRequest $request, User $admin)
    {
        $admin->update([
                'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
                'password' => bcrypt($request->input('password'))
            ] + $request->all());


        return response()->json('Admin Update Successfully');
    }

    public function destroy(User $admin)
    {
        $admin->delete();

        return response()->json('Admin Update Successfully');
    }
}
