<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\StoreAccountRequest;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedById;

class AccountController extends Controller
{
    /**
     * @param StoreAccountRequest $request
     *
     * @throws TenantCouldNotBeIdentifiedById
     *
     * @return JsonResponse
     */
    public function store(StoreAccountRequest $request): JsonResponse
    {
        $account = Account::create([
          'database' => $request->validated('domain'),
          'company_name' => $request->validated('company'),
        ]);

        $account->domains()->create([
          'domain' => $request->validated('domain'),
        ]);

//        tenancy()->initialize($request->validated('domain'));
//
//        User::create([
//          'name' => $request->validated('name'),
//          'email' => $request->validated('email'),
//        ]);

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
