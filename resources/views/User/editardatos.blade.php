@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')
<style>
    .form-control{
        border-top-left-radius: 5px !important;
        border-bottom-left-radius: 5px !important;
        border-top-right-radius: 5px !important;
        border-bottom-right-radius: 5px !important;
        padding-left: 10px !important;
        border-width: 1px;
    }
    input{
        margin-left:10px !important;
        border:0.5px solid !important;


    }
</style>

        <center><h1></h1></center>

        <br>
        <br>

        <form action="{{route('usuario.actualizar')}}" method="post">
            @method("put")
            @csrf
            <div class="input-group mb-3">
        <label for="" style="width:20%">Nombre Completo:</label>
            <input name="name" type="text"  title="Ingrese su nombre completo" class="form-control @error('name') is-invalid @enderror" value="{{auth()->user()->name}}" >
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        

        <div class="input-group mb-3">
            <label for="" style="width:20%">Nombre de Usuario:</label>
            <input name="username" type="text" title="Ingrese un  username" class="form-control @error('username') is-invalid @enderror" value="{{auth()->user()->username}}" >
            @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="input-group mb-3">
            <label for="" style="width:20%">Correo Electrónico:</label>
            <input name="correo" type="text" title="Ingrese el correo electrónico" class="form-control @error('correo') is-invalid @enderror" value="{{auth()->user()->correo}}" >
            @error('correo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        
        </div>

        <div class="input-group mb-3">
            <label for="" style="width:20%">Fecha de Nacimiento:</label>
            <input name="nacimiento" type="text" title="Ingrese su fecha de nacimiento" class="form-control @error('nacimiento') is-invalid @enderror" id="nacimiento" value="{{auth()->user()->nacimiento}}">
        
            @error('nacimiento')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="input-group mb-3">
            <label for="" style="width:20%">Identidad:</label>
            <input name="identidad" type="text"  title="Ingresar número de Identidad separado por guiones" maxlength="15" pattern="[0-9]{4}-[0-9]{4}-[0-9]{5}"  class="form-control @error('identidad') is-invalid @enderror"  value="{{auth()->user()->identidad}}" >
            @error('identidad')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="input-group mb-3">
            <label for="" style="width:20%">Teléfono:</label>
            <input name="telefono" type="text" title="Ingrese el número teléfonico" autofocus maxLength="9" class="form-control @error('telefono') is-invalid @enderror" value="{{auth()->user()->telefono}}" >
            @error('telefono')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

      
        <br>
        <button type="submit" class="btn btn-primary" ><span class="fas fa-user-plus"></span>
          Guardar Cambios
       </button>
        
       
       <a type="button" class="btn btn-danger" href="/usuario"><i class="fa fa-times" aria-hidden="true"></i>
            Cancelar
        </a>
            
        </form>
        
      

       

@stop