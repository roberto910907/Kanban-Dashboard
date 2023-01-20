<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

class AccountController extends Controller
{
    /**
     * TODO: Add a form request with domain validation.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $account = Account::create([
            'name' => $request->request->get('name'),
            'email' => $request->request->get('email'),
            'database' => $request->request->get('domain'),
        ]);

        $account->domains()->create([
            'domain' => $request->request->get('domain'),
        ]);

        return response()->json([
            'success' => true,
            'accountUrl' => sprintf(
                '%s://%s.%s',
                Route::getCurrentRequest()->getScheme(),
                $request->get('domain'),
                Route::getCurrentRequest()->getHost()
            ),
        ]);
    }
}
