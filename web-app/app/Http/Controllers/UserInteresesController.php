<?php

namespace App\Http\Controllers;

use App\Models\UserIntereses;
use App\Models\CategoriaInteres;
use App\Models\OpcionInteres;
use Illuminate\Http\Request;

class UserInteresesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        $intereses = UserIntereses::with('opcion.categoria')
            ->where('user_id', $user->id)
            ->get();

        return inertia('UserIntereses/Index', [
            'intereses' => $intereses
        ]);
    }

    public function create()
    {
        return inertia('UserIntereses/Create', [
            'categorias' => CategoriaInteres::all(),
            'opciones' => OpcionInteres::all(),
        ]);
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'opciones' => 'required|array',
        'opciones.*' => 'exists:opcion_intereses,id',
    ]);

    $user = auth()->user();

    // 👉 No borrar intereses anteriores, solo agregar los nuevos.
    foreach ($validated['opciones'] as $opcion_id) {

        // Evitar duplicados
        $yaExiste = UserIntereses::where('user_id', $user->id)
            ->where('opcion_interes_id', $opcion_id)
            ->exists();

        if (!$yaExiste) {
            UserIntereses::create([
                'user_id' => $user->id,
                'opcion_interes_id' => $opcion_id,
            ]);
        }
    }

    return redirect()->route('profile.edit')
        ->with('success', 'Intereses guardados correctamente.');
}


    public function edit(UserIntereses $userIntereses)
    {
        if ($userIntereses->user_id !== auth()->id()) {
            abort(403);
        }

        return inertia('UserIntereses/Edit', [
            'interes' => $userIntereses,
            'categorias' => CategoriaInteres::all(),
            'opciones' => OpcionInteres::all(),
        ]);
    }

    public function update(Request $request, UserIntereses $userIntereses)
    {
        if ($userIntereses->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'opcion_interes_id' => 'required|exists:opcion_intereses,id'
        ]);

        $userIntereses->update($validated);

        return redirect()->route('profile.edit')
            ->with('success', 'Interés actualizado correctamente.');
    }

    public function destroy(UserIntereses $userIntereses)
    {
        if ($userIntereses->user_id !== auth()->id()) {
            abort(403);
        }

        $userIntereses->delete();

        return redirect()->back()
            ->with('success', 'Interés eliminado correctamente.');
    }
    public function destroyAll()
{
    $user = auth()->user();

    UserIntereses::where('user_id', $user->id)->delete();

    return redirect()->route('profile.edit')
        ->with('success', 'Todos los intereses fueron eliminados.');
}

}
