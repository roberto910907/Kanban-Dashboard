<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Column;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CardController extends Controller
{
    /**
     * TODO: Implement store request here
     *
     * @param Request $request
     * @param Column $column
     *
     * @return JsonResponse
     */
    public function list(Request $request, Column $column): JsonResponse
    {
        return response()->json([
          'cards' => Card::query()->where('column_id', $column->id)->orderBy('position')->get(),
        ]);
    }

    /**
     * TODO: Implement store request here
     *
     * @param Request $request
     * @param Column $column
     *
     * @return JsonResponse
     */
    public function store(Request $request, Column $column): JsonResponse
    {
        $lastCard = Card::query()->orderBy('position', 'desc')->first();
        $lastPosition = $lastCard->position ?? 0;

        $newCard = Card::create([
          'position' => $lastPosition,
          'column_id' => $column->id,
          ...$request->all(),
        ]);

        return response()->json([
          'id' => $newCard->id,
        ]);
    }
}
