<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\CategoriaInteres;
use App\Models\OpcionInteres;
use Illuminate\Http\Request;
use App\DTO\UserContext;
use App\Services\EventoRecomendadorService;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::with('categoria:id,nombre', 'opcion:id,nombre,categoria_interes_id')
            ->get();

        return inertia('Eventos/Index', [
            'eventos' => $eventos //para
        ]);
    }

    public function create()
    {
        return inertia('Eventos/Create', [
            'categorias' => CategoriaInteres::all(),
            'opciones'   => OpcionInteres::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',

            'categoria_interes_id' => 'required|exists:categorias_interes,id',
            'opcion_interes_id'    => 'required|exists:opcion_intereses,id',

            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',

            'direccion_texto' => 'required|string',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
        ]);

        $validated['user_id'] = auth()->id();

        Evento::create($validated);

        return redirect()->route('eventos.mapa')
            ->with('success', 'Evento creado correctamente');
    }

    // ============================================================
    //  GET: carga la VISTA del mapa
    // ============================================================
    public function mapa()
    {
        $usuario = auth()->user();

        // Intereses del usuario
        $interesesNombres = $usuario->intereses()
            ->with('opcion')
            ->get()
            ->pluck('opcion.nombre')
            ->filter()
            ->values()
            ->toArray();

        // Eventos SIN cálculo aún
        $eventos = Evento::with([
            'categoria:id,nombre',
            'opcion:id,nombre,categoria_interes_id'
        ])
        ->get([
            'id','titulo','categoria_interes_id','opcion_interes_id',
            'latitud','longitud','fecha','hora_inicio','hora_fin','direccion_texto'
        ]);

        return inertia('Eventos/Mapa', [
            'eventos'                 => $eventos,
            'interesesUsuarioNombres' => $interesesNombres,
        ]);
    }

    // ============================================================
    //  POST: recibe ubicación → calcula distancia → retorna JSON
    // ============================================================
    

    public function actualizarMapa(Request $request, EventoRecomendadorService $recomendador)
    {
        $usuario = auth()->user();

        $lat = $request->lat_usuario ?: $usuario->latitud;
        $lng = $request->lng_usuario ?: $usuario->longitud;

        $interesesIds = $usuario->intereses()->pluck('opcion_interes_id')->toArray();

        $interesesNombres = $usuario->intereses()
            ->with('opcion')
            ->get()
            ->pluck('opcion.nombre')
            ->filter()
            ->values()
            ->toArray();

        $ctx = new UserContext(
            $interesesIds,
            $interesesNombres,
            $lat ? (float)$lat : null,
            $lng ? (float)$lng : null
        );

        return response()->json([
            'eventos' => $recomendador->recomendar($ctx)
        ]);
    }

}
