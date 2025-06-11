<?php

namespace App\Http\Controllers\Etiquetas;

use App\Http\Controllers\Controller;
use App\Models\Etiqueta;
use Illuminate\Http\Request;

class EtiquetaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:etiquetas.ver')->only('index');
        $this->middleware('permission:etiquetas.crear')->only(['create', 'store']);
        $this->middleware('permission:etiquetas.editar')->only(['edit', 'update']);
        $this->middleware('permission:etiquetas.eliminar')->only('destroy');
        $this->middleware('permission:etiquetas.restaurar')->only('restaurar');
    }

    public function index(Request $request)
    {
        $filtro = $request->input('filtro', 'activos');

        if ($filtro === 'eliminados') {
            $etiquetas = Etiqueta::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        } elseif ($filtro === 'todos') {
            $etiquetas = Etiqueta::withTrashed()->orderBy('created_at', 'desc')->get();
        } else {
            $etiquetas = Etiqueta::orderBy('created_at', 'desc')->get(); // Activos
        }

        return view('etiquetas.index', compact('etiquetas', 'filtro'));
    }

    public function create()
    {
        return view('etiquetas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:etiquetas,nombre',
        ]);

        Etiqueta::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('etiquetas.index')->with('success', 'Etiqueta creada con éxito.');
    }

    public function edit($id)
    {
        $etiqueta = Etiqueta::findOrFail($id);
        return view('etiquetas.edit', compact('etiqueta'));
    }

    public function update(Request $request, $id)
    {
        $etiqueta = Etiqueta::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255|unique:etiquetas,nombre,' . $etiqueta->id,
        ]);

        $etiqueta->update([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('etiquetas.index')->with('success', 'Etiqueta actualizada correctamente.');
    }

    public function destroy($id)
    {
        $etiqueta = Etiqueta::findOrFail($id);
        $etiqueta->delete();

        return redirect()->route('etiquetas.index')->with('success', 'Etiqueta eliminada correctamente.');
    }

    public function restaurar($id)
    {
        $etiqueta = Etiqueta::onlyTrashed()->findOrFail($id);
        $etiqueta->restore();

        return redirect()->route('etiquetas.index')->with('success', 'Etiqueta restaurada con éxito.');
    }
}
