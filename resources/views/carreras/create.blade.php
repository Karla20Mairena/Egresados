@extends('layouts.app')

@section('title', 'Crear Carrera')

@section('content')



<form action ="../carreras"  method="POST">
    @csrf
<div class="mb-3">
    <label for="" class="form-label">Nombre de la carrera</label>
    <input type="text" value="{{old('carrera')}}"  name="carrera" id="carrera"  class="form-control @error('carrera') is-invalid @enderror"  tabindex="1"
    title="Ingrese el nombre completo del egresado">

    @error('carrera')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
</div>

<button type="submit" class="btn btn-primary" tabindex="4"><span class="fas fa-user-plus"></span> Guardar</button>
<a href="../carreras" class="btn btn-danger" tabindex="5"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</a>


</form>

@endsection