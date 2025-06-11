<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Etiqueta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:clientes.ver')->only('index');
        $this->middleware('permission:clientes.crear')->only(['create', 'store']);
        $this->middleware('permission:clientes.editar')->only(['edit', 'update']);
        $this->middleware('permission:clientes.eliminar')->only(['destroy', 'restaurar']);
        $this->middleware('permission:clientes.restaurar')->only('restaurar');

    }

    public function index(Request $request)
    {
        $filtro = $request->input('filtro', 'activos');

        if ($filtro === 'eliminados') {
            $clientes = Cliente::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        } elseif ($filtro === 'todos') {
            $clientes = Cliente::withTrashed()->orderBy('created_at', 'desc')->get();
        } else {
            $clientes = Cliente::orderBy('created_at', 'desc')->get(); // Activos
        }

        return view('clientes.index', compact('clientes', 'filtro'));
    }

    public function create()
    {
            $etiquetas = \App\Models\Etiqueta::orderBy('nombre')->get();
            return view('clientes.create', compact('etiquetas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:clientes,correo',
            'telefono' => [
                'nullable',
                'digits:8',
                'regex:/^[0-9]{8}$/',
                'unique:clientes,telefono',
            ],
            
            'etiquetas' => 'nullable|array',
            'etiquetas.*' => 'exists:etiquetas,id',
        ]);

         $cliente = Cliente::create([
        'nombre' => $request->nombre,
        'correo' => $request->correo,
        'telefono' => $request->telefono,
        
        ]);

        if ($request->filled('etiquetas')) {
            $cliente->etiquetas()->sync($request->etiquetas);
        }

        return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente.');
    }

    public function edit($id)
    {
         $cliente = Cliente::findOrFail($id);
         $etiquetas = Etiqueta::all(); // ← Agregado

        return view('clientes.edit', compact('cliente', 'etiquetas'));
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:clientes,correo,' . $cliente->id,
            'telefono' => [
                'nullable',
                'digits:8',
                'regex:/^[0-9]{8}$/',
                'unique:clientes,telefono,' . $cliente->id,
            ],
            'etiquetas' => 'nullable|array',
            'etiquetas.*' => 'exists:etiquetas,id',
        ]);

        $cliente->update([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
        ]);

        // Sincronizar etiquetas, aunque esté vacío
        $cliente->etiquetas()->sync($request->etiquetas ?? []);

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');
    }


    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente.');
    }

    public function show($id)
    {
            $cliente = Cliente::with('etiquetas')->withTrashed()->findOrFail($id);
            return view('clientes.show', compact('cliente'));
    }

    public function restaurar($id)
    {
        $cliente = Cliente::onlyTrashed()->findOrFail($id);
        $cliente->restore();

        return redirect()->route('clientes.index')->with('success', 'Cliente restaurado exitosamente.');
    }
}