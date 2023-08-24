@extends('layouts.app')

@section('title', 'Editar Carrera')

@section('content')


<form method="POST" action ="{{ route('carrera.update',['id'=>$carrera->id])}}">
@method('put')
    @csrf

   
<div class="mb-3">
    <label for="" class="form-label">Nombre de la carrera</label>
    <input type="text" class="form-control @error('carrera') is-invalid @enderror" name="carrera" id="carrera" 
     value="{{ $carrera->Carrera }}" title="Ingrese el nombre completo del egresado">
     @error('carrera')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
</div>

<button type="submit" class="btn btn-primary" tabindex="4"><span class="fas fa-user-plus"></span>Guardar cambios</button>
<a href="/carreras" class="btn btn-danger" tabindex="5"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</a>

@endsection