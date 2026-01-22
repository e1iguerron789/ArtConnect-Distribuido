<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoriaInteres;
use Illuminate\Http\Request;

class CategoriaInteresController extends Controller
{
    public function index()
    {
        return inertia('Admin/CategoriasInteres/Index', [
            'categorias' => CategoriaInteres::all()
        ]);
    }

    public function create()
    {
        return inertia('Admin/CategoriasInteres/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias_interes,nombre',
        ]);

        CategoriaInteres::create($request->all());

        return redirect()->route('admin.categorias-interes.index')
            ->with('success', 'Categoría creada correctamente');
    }

    public function edit(CategoriaInteres $categorias_intere)
    {
        return inertia('Admin/CategoriasInteres/Edit', [
            'categoria' => $categorias_intere
        ]);
    }

    public function update(Request $request, CategoriaInteres $categorias_intere)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias_interes,nombre,' . $categorias_intere->id,
        ]);

        $categorias_intere->update($request->all());

        return redirect()->route('admin.categorias-interes.index')
            ->with('success', 'Categoría actualizada correctamente');
    }

    public function destroy(CategoriaInteres $categorias_intere)
    {
        $categorias_intere->delete();

        return redirect()->route('admin.categorias-interes.index')
            ->with('success', 'Categoría eliminada correctamente');
    }
}
