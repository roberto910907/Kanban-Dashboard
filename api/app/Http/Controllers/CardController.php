<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Column;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreCardRequest;
use App\Http\Requests\UpdateCardRequest;
use App\Http\Requests\UpdateCardColumnRequest;
use App\Http\Requests\UpdateCardPositionRequest;

class CardController extends Controller
{
    /**
     * @param Column $column
     *
     * @return JsonResponse
     */
    public function list(Column $column): JsonResponse
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
     * @param StoreCardRequest $request
     * @param Column $column
     *
     * @return JsonResponse
     */
    public function store(StoreCardRequest $request, Column $column): JsonResponse
    {
        $lastCard = Card::query()
          ->where('column_id', $column->id)
          ->orderBy('position', 'desc')
          ->first();

        $lastPosition = $lastCard->position ?? 0;

        $newCard = Card::create([
          'position' => $lastPosition + 1,
          'column_id' => $column->id,
          'title' => $request->validated('title'),
        ]);

        return response()->json([
          'id' => $newCard->id,
        ]);
    }

    /**
     * @param UpdateCardRequest $request
     * @param Card $card
     *
     * @return JsonResponse
     */
    public function update(UpdateCardRequest $request, Card $card): JsonResponse
    {
        $card->update([
          'title' => $request->validated('title'),
          'description' => $request->validated('description'),
        ]);

        return response()->json(['status' => 'success']);
    }

    /**
     * @param UpdateCardPositionRequest $request
     * @param Card $card
     *
     * @return JsonResponse
     */
    public function updatePosition(UpdateCardPositionRequest $request, Card $card): JsonResponse
    {
        $card->update(['position' => $request->validated('position')]);

        return response()->json(['status' => 'success']);
    }

    /**
     * @param UpdateCardColumnRequest $request
     * @param Card $card
     *
     * @return JsonResponse
     */
    public function updateColumn(UpdateCardColumnRequest $request, Card $card): JsonResponse
    {
        $card->update([
          'column_id' => $request->validated('column_id'),
          'position' => $request->validated('position'),
        ]);

        return response()->json(['status' => 'success']);
    }
}
