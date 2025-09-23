@extends('layouts.app')

@section('content')
    <h1>Detalle del Producto</h1>

    <p><strong>ID:</strong> {{ $producto->id }}</p>
    <p><strong>Nombre:</strong> {{ $producto->nombre }}</p>
    <p><strong>Precio:</strong> {{ $producto->precio }}</p>
    <p><strong>Categoría:</strong> {{ $producto->categoria->nombre ?? 'Sin categoría' }}</p>
    <p><img src="{{ asset('img/'.$producto->imagen) }}" alt="Imagen del producto" width="200"></p>

    <a href="{{ route('producto.index') }}" class="btn btn-secondary">Volver</a>
@endsection
