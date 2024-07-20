<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class CacheController extends Controller
{
    public function clearCache()
    {
        Artisan::call('cache:clear');
        return response()->json([
            'status' => true,
            'message' => 'Cache cleared successfully!'
        ]);
    }

    public function clearRouteCache()
    {
        Artisan::call('route:clear');
        return response()->json([
            'status' => true,
            'message' => 'Route cache cleared successfully!'
        ]);
    }

    public function clearConfigCache()
    {
        Artisan::call('config:clear');
        return response()->json([
            'status' => true,
            'message' => 'Config cache cleared successfully!'
        ]);
    }
}
