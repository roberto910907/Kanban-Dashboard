<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Column;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreColumnRequest;

class ColumnController extends Controller
{
    /**
     * @param Board $board
     *
     * @return JsonResponse
     */
    public function list(Board $board): JsonResponse
    {
        return response()->json([
            'columns' => Column::query()
              ->where('board_id', $board->id)
              ->with(['cards' => function ($query) {
                  $query->orderByPosition();
              }])
              ->oldest('position')
              ->get(),
        ]);
    }

    /**
     * @param StoreColumnRequest $request
     * @param Board $board
     *
     * @return JsonResponse
     */
    public function store(StoreColumnRequest $request, Board $board): JsonResponse
    {
        $lastColumn = Column::query()->orderBy('position', 'desc')->first();
        $lastPosition = $lastColumn->position ?? 0;

        $newColumn = Column::create([
            'position' => $lastPosition + 1,
            'title' => $request->validated('title'),
            'board_id' => $board->uuid,
        ]);

        return response()->json([
            'id' => $newColumn->id,
        ]);
    }

    /**
     * @param Column $column
     *
     * @return JsonResponse
     */
    public function delete(Column $column): JsonResponse
    {
        DB::beginTransaction();

        $column->delete();
        $column->cards()->delete(); // cascade delete for related cards

        DB::commit();

        return response()->json(['status' => 'success']);
    }
}
