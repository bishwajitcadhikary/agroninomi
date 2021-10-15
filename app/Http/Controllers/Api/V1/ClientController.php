<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'first_name' => ['required', 'string'],
                'last_name' => ['required', 'string'],
                'email' => ['required', 'string', 'unique:users'],
                'password' => ['required', 'string']
            ]);

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

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return User
     */
    public function show(User $client)
    {
        return $client;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            $client = User::findOrFail($id);

            $client->delete();

            return \response()->json('Client Deleted Successfully');
        }catch (ModelNotFoundException $exception){
            return \response()->json('Client Not Found');
        }catch (Throwable $exception){
            return response()->json($exception->getMessage(), 422);
        }
    }
}
