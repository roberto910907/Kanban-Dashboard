<?php

namespace App\Http\Controllers;

use App\Models\Column;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreColumnRequest;

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
          'columns' => Column::query()
            ->with(['cards' => function ($query) {
                $query->orderByPosition();
            }])
            ->oldest('position')
            ->get(),
        ]);
    }

    /**
     * @param StoreColumnRequest $request
     *
     * @return JsonResponse
     */
    public function store(StoreColumnRequest $request): JsonResponse
    {
        $lastColumn = Column::query()->orderBy('position', 'desc')->first();
        $lastPosition = $lastColumn->position ?? 0;

        $newColumn = Column::create([
          'position' => $lastPosition + 1,
          'title' => $request->validated('title'),
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
