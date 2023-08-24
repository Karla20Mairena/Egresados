@extends('layouts.app')

@section('title', 'Crear Egresado')

@section('content')

<form action ="../egresado"  method="POST">
    @csrf

    <div class="mb-3">
    <label for="" class="form-label">Identidad</label>
    <input type="text"  maxlength="13" 
    title="Ingrese número de Identidad" value="{{old('identidad')}}" 
    name="identidad" id="identidad" 
    class="form-control @error('identidad') is-invalid @enderror" placeholder="0000000000000"
    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">

    @error('identidad')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
  </div>



<div class="mb-3">
        <label for="" class="form-label">Nombre Completo</label>
        <input type="text"  maxlength="100"   value="{{old('nombre')}}"  name="nombre"  id="nombre"   
        class="form-control @error('nombre') is-invalid @enderror" placeholder="Nombre Completo del Estudiante"
        title="Ingrese el nombre completo del egresado">
        @error('nombre')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
      
      </div>


      <div class="mb-3">
        <label for="" class="form-label">Fecha de Nacimiento</label>
        <input type="" value="{{old('fecha')}}" name="fecha"  id="fecha"  
        class="form-control @error('fecha') is-invalid @enderror" placeholder="aa-mm-dd" 
        title="Ingrese la fecha de nacimiento " autofocus>

      
        @error('fecha')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
      </div>

      <div class="for-group">
        <label for="">Género</label>
        <select class="form-control" name="gene_id">
        @foreach ($generos as $genero)
        <option value="{{$genero->id}}">{{$genero->name}}</option>
        @endforeach      
      </select>
      </div>

      <div class="mb-3">
      <label for="">Carrera</label>
      <select class="form-control" name="carre_id">
        @foreach ($carreras as $carrera)
        <option value="{{$carrera->id}}">{{$carrera->Carrera}}</option>
        @endforeach      
      </select>
      </div> 

      <div class="mb-3">
        <label for="">Año de Egreso</label>
        <input type="number"value="{{old('egreso')}}"  name="egreso"  id="egreso" 
        class="form-control @error('egreso') is-invalid @enderror"   placeholder="####"
        title="Ingrese el año de egreso">
      
        @error('egreso')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
      </div>

      <div class="mb-3">
        <label for="">Número de Expediente</label>
        <input type="number"value="{{old('expediente')}}"  name="expediente"  id="expediente" 
        class="form-control @error('expediente') is-invalid @enderror"   placeholder="####"
        title="Ingrese el número de expediente">
      
        @error('expediente')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
      </div>
<link rel="stylesheet" type="text/css" href="css/fonts.css" >     
<button type="submit"class="btn btn-primary" tabindex="4"><span class="fas fa-user-plus"></span> Guardar</button> 

<a href="../egresado" class="btn btn-danger" tabindex="5"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</a>
<br>
<br>


</form>


@endsection