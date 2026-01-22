<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoriaInteres;
use App\Models\OpcionInteres;
use Illuminate\Http\Request;

class OpcionInteresController extends Controller
{
    public function index()
    {
        return inertia('Admin/OpcionesInteres/Index', [
            'opciones' => OpcionInteres::with('categoria')->get(),
            'categorias' => CategoriaInteres::all()
        ]);
    }

    public function create()
    {
        return inertia('Admin/OpcionesInteres/Create', [
            'categorias' => CategoriaInteres::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'categoria_interes_id' => 'required|exists:categorias_interes,id',
            'nombre' => 'required|string|max:100',
        ]);

        OpcionInteres::create($request->all());

        return redirect()->route('admin.opciones-interes.index')
            ->with('success', 'Opción creada correctamente');
    }

    public function edit(OpcionInteres $opciones_intere)
    {
        return inertia('Admin/OpcionesInteres/Edit', [
            'opcion' => $opciones_intere,
            'categorias' => CategoriaInteres::all()
        ]);
    }

    public function update(Request $request, OpcionInteres $opciones_intere)
    {
        $request->validate([
            'categoria_interes_id' => 'required|exists:categorias_interes,id',
            'nombre' => 'required|string|max:100',
        ]);

        $opciones_intere->update($request->all());

        return redirect()->route('admin.opciones-interes.index')
            ->with('success', 'Opción actualizada correctamente');
    }

    public function destroy(OpcionInteres $opciones_intere)
    {
        $opciones_intere->delete();

        return redirect()->route('admin.opciones-interes.index')
            ->with('success', 'Opción eliminada correctamente');
    }
}
