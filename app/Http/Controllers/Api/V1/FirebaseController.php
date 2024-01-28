<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class FirebaseController extends Controller
{
    public function __construct(){}

    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'fmc_token' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $request->user()->update([
                'fmc_token' => $request->fmc_token,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Success'
            ]);

        } catch (Exception $exception)
        {
            DB::rollBack();

            return response()->json($exception);
        }
    }
}
