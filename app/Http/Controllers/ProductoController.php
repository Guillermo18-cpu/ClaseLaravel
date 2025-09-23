<?php

namespace App\Http\Controllers;
use App\Models\Producto;
use App\Models\Categoria;
use App\Http\Requests\ProductoRequest;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categorias=Categoria::all(); 
        $productos=Producto::orderBy('id','DESC')->paginate(4);
        return view('producto.index',compact('productos','categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categorias=Categoria::orderBy('id','DESC')->select('categorias.id','categorias.nombre')->get();
        return view('producto.create',compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductoRequest $request)
    {
        //procesar la imagen 

        if($request->hasFile('imagen')){
            $imagen=$request->file('imagen');
            $nombreImagen=time().'.'.$imagen->getClientOriginalExtension();
            $imagen->move(public_path('img'),$nombreImagen);
        }
        //asignacion masiva
        $data=$request->except('imagen');
        $data['imagen']=$nombreImagen;
        Producto::create($data);
        return redirect()->route('producto.index')->with('success','Producto agregado con exito');

    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
        return view('producto.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
         $categorias=Categoria::orderBy('id','DESC')->select('categorias.id','categorias.nombre')->get();
        $producto=Producto::findOrFail($id);

        return view('producto.create', compact('producto','categorias'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductoRequest $request,$id)
    {
        //
        

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        //
        if ($producto->imagen && file_exists(public_path('img/'.$producto->imagen))) {
            unlink(public_path('img/'.$producto->imagen));
        }

        $producto->delete();

        return redirect()->route('producto.index')->with('success', 'Producto eliminado con exito');
    }
}
