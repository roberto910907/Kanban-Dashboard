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
        $cards = Card::query()
          ->where('column_id', $column->id)
          ->orderByPosition()
          ->get();

        return response()->json([
          'cards' => $cards,
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
        $lastCard = Card::query()
          ->where('column_id', $column->id)
          ->orderBy('position', 'desc')
          ->first();

        $lastPosition = $lastCard->position ?? 0;

        $newCard = Card::create([
          'position' => $lastPosition + 1,
          'column_id' => $column->id,
          ...$request->all(),
        ]);

        return response()->json([
          'id' => $newCard->id,
        ]);
    }

    /**
     * TODO: Implement store request here
     *
     * @param Request $request
     * @param Card $card
     *
     * @return JsonResponse
     */
    public function updatePosition(Request $request, Card $card): JsonResponse
    {
        $card->update(['position' => $request->request->get('position')]);

        return response()->json(['status' => 'success']);
    }

    /**
     * TODO: Implement store request here
     *
     * @param Request $request
     * @param Card $card
     *
     * @return JsonResponse
     */
    public function updateColumn(Request $request, Card $card): JsonResponse
    {
        $card->update([
          'column_id' => $request->request->get('column_id'),
          'position' => $request->request->get('position'),
        ]);

        return response()->json(['status' => 'success']);
    }
}
