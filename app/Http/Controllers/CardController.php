<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Column;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreCardRequest;
use App\Http\Requests\FilterCardRequest;
use App\Http\Requests\UpdateCardColumnRequest;
use App\Http\Requests\UpdateCardPositionRequest;

class CardController extends Controller
{
    public const STATUS_ACTIVE = '1';
    public const STATUS_INACTIVE = '0';

    /**
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
     * @param FilterCardRequest $request
     *
     * @return Response
     */
    public function filterCards(FilterCardRequest $request): Response
    {
        $cardsQuery = Card::query()->withTrashed();

        if ($creationDate = $request->get('date')) {
            $cardsQuery->whereDate('created_at', $creationDate);
        }

        $status = $request->query('status');

        if ($status === self::STATUS_ACTIVE) {
            $cardsQuery->whereNull('deleted_at');
        } elseif ($status === self::STATUS_INACTIVE) {
            $cardsQuery->whereNotNull('deleted_at');
        }

        return response($cardsQuery->get());
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
