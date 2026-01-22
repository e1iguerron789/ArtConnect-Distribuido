<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventoRequest;
use App\Http\Requests\UpdateEventoRequest;
use App\Http\Resources\EventoResource;
use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function index(Request $request)
    {
        $q = Evento::query()->latest();

        if ($request->filled('user_id')) {
            $userId = (int) $request->query('user_id');
            $q->where('user_id', $userId);
        }

        return EventoResource::collection($q->paginate(10));
    }

    public function store(StoreEventoRequest $request)
    {
        $evento = Evento::create($request->validated());
        return (new EventoResource($evento))->response()->setStatusCode(201);
    }

    public function show($id)
    {
        $evento = Evento::findOrFail($id);
        return new EventoResource($evento);
    }

    public function update(UpdateEventoRequest $request, $id)
    {
        $evento = Evento::findOrFail($id);
        $evento->update($request->validated());
        return new EventoResource($evento);
    }

    public function destroy($id)
    {
        $evento = Evento::findOrFail($id);
        $evento->delete();
        return response()->json(['message' => 'deleted'], 200);
    }
}
