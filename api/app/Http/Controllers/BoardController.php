<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\JsonResponse;

class BoardController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        return response()->json([
          'boards' => Board::all(),
        ]);
    }
}
