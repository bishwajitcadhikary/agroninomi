<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ClientRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:client_read')->only('index', 'show');
        $this->middleware('permission:client_create')->only('store');
        $this->middleware('permission:client_update')->only('update');
        $this->middleware('permission:client_delete')->only('destroy');
    }

    public function index()
    {
        return User::role('client')->get();
    }

    public function store(ClientRequest $request)
    {
        try {
            $user = User::create([
                    'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
                    'password' => bcrypt($request->input('password'))
                ] + $request->all());

            $user->assignRole('client');

            return response()->json('Client Created Successfully', 201);
        } catch (Throwable $exception) {
            return response()->json($exception->getMessage(), 422);
        }
    }

    public function show(User $client)
    {
        return $client;
    }

    public function destroy(User $client)
    {
        try {
            $client->delete();

            return response()->json('Client Deleted Successfully');
        } catch (ModelNotFoundException $exception) {
            return response()->json('Client Not Found', 404);
        } catch (Throwable $exception) {
            return response()->json($exception->getMessage(), 422);
        }
    }
}
