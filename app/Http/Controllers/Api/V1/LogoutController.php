<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json('Logout Successfully');
        }catch (\Throwable $exception){
            return response()->json($exception->getMessage(), 422);
        }
    }
}
