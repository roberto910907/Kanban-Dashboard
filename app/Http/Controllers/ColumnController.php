<?php

namespace App\Http\Controllers;

use App\Models\Column;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ColumnController extends Controller
{
    /**
     * TODO: Implement store request here
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        return response()->json([
          'columns' => Column::query()->orderBy('position')->with('cards')->get(),
        ]);
    }

    /**
     * TODO: Implement store request here
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $lastColumn = Column::query()->orderBy('position', 'desc')->first();
        $lastPosition = $lastColumn->position ?? 0;

        $newColumn = Column::create([
          'position' => $lastPosition,
          ...$request->all(),
        ]);

        return response()->json([
          'id' => $newColumn->id,
        ]);
    }
}
