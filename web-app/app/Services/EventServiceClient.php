<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class EventServiceClient
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.event_service.url'), '/');
    }

    private function http(?string $token = null)
    {
        $client = Http::baseUrl($this->baseUrl)
            ->acceptJson()
            ->timeout(4);

        if ($token) {
            $client = $client->withToken($token);
        }

        return $client;
    }

    public function list(array $query = [], ?string $token = null): array
    {
        return $this->http($token)->get('/api/events', $query)->throw()->json();
    }

    public function create(array $data, ?string $token = null): array
    {
        return $this->http($token)->post('/api/events', $data)->throw()->json();
    }

    public function get(int $id, ?string $token = null): array
    {
        return $this->http($token)->get("/api/events/{$id}")->throw()->json();
    }

    public function update(int $id, array $data, ?string $token = null): array
    {
        return $this->http($token)->patch("/api/events/{$id}", $data)->throw()->json();
    }

    public function delete(int $id, ?string $token = null): array
    {
        // algunos deletes no devuelven json; lo manejamos igual:
        $res = $this->http($token)->delete("/api/events/{$id}");
        if ($res->successful()) {
            return $res->json() ?? ['message' => 'deleted'];
        }
        $res->throw();
        return [];
    }
}
