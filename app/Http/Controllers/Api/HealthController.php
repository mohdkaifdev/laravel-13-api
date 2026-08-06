<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class HealthController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => 'API is working',
            'laravel_version' => app()->version(),
            'redis' => Cache::get('test_key') ? 'connected' : 'failed'
        ]);
    }
}