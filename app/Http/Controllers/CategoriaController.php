<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Http\Requests\CategoriaRequest;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categorias=Categoria::orderBy('id','DESC')->paginate(8);
        return view('categoria.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('categoria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar datos del formulario 
        $validateData=$request->validate(
            [
            'nombre' => 'required|max:255|unique:categorias,nombre',
            'descripcion' => 'required',
            'status' => 'required|boolean',
        ], [
            'nombre.required' => 'El campo nombre es obligatorio',
            'nombre.max' => 'El nombre debe tener máximo 255 caracteres',
            'nombre.unique' => 'El nombre ya existe en la base de datos',
            'descripcion.required' => 'El campo descripción es obligatorio',
            'status.required' => 'El campo status es obligatorio',
        ]    
        );

    // crear una nueva categoria
    //$categoria = new Categoria();
    //$categoria->nombre = $validateData['nombre'];
    //$categoria->descripcion = $validateData['descripcion'];
    //$categoria->status = $validateData['status'];

    //$categoria->save();

    $categoria=Categoria::create($validateData);

    return redirect()->route('categoria.index')->with('success', 'Categoría agregada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $categoria=Categoria::findOrFail($id);
        return view('categoria.edit', ['categoria'=>$categoria]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoriaRequest $request, $id)
    {
        //
        $categoria=Categoria::fineOrFail($id);
        $categoria->update($request->validated());

        return redirect() ->rout('categoria.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        //
         $categoria=Categoria::findOrFail($id);
        $categoria->delete();
        return redirect()->route('categoria.index');
    }
}
