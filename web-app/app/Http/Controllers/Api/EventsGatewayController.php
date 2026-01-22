<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\EventServiceClient;
use Illuminate\Http\Request;

class EventsGatewayController extends Controller
{
    public function index(Request $request, EventServiceClient $client)
{
    $userId = (int) ($request->query('user_id') ?? 0);
    $token = $request->bearerToken();

    $query = [];
    if ($userId > 0) {
        $query['user_id'] = $userId;
    }

    try {
        $data = $client->list($query, $token);
        return response()->json($data);
    } catch (\Throwable $e) {
        // Degradación controlada: el sistema sigue vivo aunque el microservicio caiga
        return response()->json([
            'message' => 'event-service unavailable',
            'service' => 'event-service',
        ], 503);
    }
}
}
