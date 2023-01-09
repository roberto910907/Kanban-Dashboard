<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Spatie\DbDumper\Databases\MySql;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function export(): JsonResponse
    {
        $fileName = sprintf('%s.sql', now()->format('Y-m-d_H-i-s'));

        MySql::create()
          ->setDbName(config('database.connections.mysql.database'))
          ->setHost(config('database.connections.mysql.host'))
          ->setUserName(config('database.connections.mysql.username'))
          ->setPassword(config('database.connections.mysql.password'))
          ->dumpToFile(Storage::disk('public')->path($fileName));

        return response()->json([
          'file' => Storage::disk('public')->url($fileName),
        ]);
    }
}
