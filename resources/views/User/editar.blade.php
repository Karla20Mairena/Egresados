@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<br>
<br>
<form action="{{route('usuario.update',['id'=>$user->id])}}" method="post">
        @method("put")
        @csrf
       

        {{-- Nombre --}}
        <label for="" class="form-label">Nombre Completo</label>
        <div class="input-group mb-3">
            <input type="text" style="width:90%" title="Ingrese su nombre completo"   name="name" class="form-control @error('name') is-invalid @enderror"
                   value= "{{ $user->name }}"  autofocus maxLength="100">


            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Username --}}
        <label for="" class="form-label">Nombre de Usuario</label>
        <div class="input-group mb-3">
            <input type="text" style="width:90%" title="Ingrese un  username" name="username" class="form-control @error('username') is-invalid @enderror"
            value= "{{ $user->username }}"  autofocus maxLength="25">

            

            @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- correo electronico --}}
        <label for="" class="form-label">Correo Electrónico</label>
        <div class="input-group mb-3">
            <input type="text" style="width:90%" title="Ingrese el correo electrónico" name="correo" class="form-control @error('correo') is-invalid @enderror"
            value= "{{ $user->correo }}" autofocus maxLength="100">

            @error('correo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- identidad --}}
        <label for="" class="form-label">Número de Identidad</label>
        <div class="input-group mb-3">
            <input type="text" style="width:90%"   maxlength="15" pattern="[0-9]{4}-[0-9]{4}-[0-9]{5}" title="Ingresar número de Identidad separado por guiones"  name="identidad" class="form-control @error('identidad') is-invalid @enderror" 
            value= "{{ $user->identidad }}" autofocus maxLength="100" placeholder="0000-0000-00000" 
            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">

            

            @error('identidad')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- fecha nacimiento --}}
        <label for="" class="form-label">Fecha de Nacimiento</label>
        <div class="input-group mb-3">
            <input type="text" style="width:90%" title="Ingrese su fecha de nacimiento" name="nacimiento" class="form-control @error('nacimiento') is-invalid @enderror" id="nacimiento"
            value= "{{ $user->nacimiento }}"  autofocus>

            

            @error('nacimiento')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        

        {{-- telefono --}}
        <label for="" class="form-label">Número Teléfonico</label>
        <div class="input-group mb-3">
            <input type="text" style="width:90%" title="Ingrese el número teléfonico" name="telefono" class="form-control @error('telefono') is-invalid @enderror" 
            value= "{{ $user->telefono }}" autofocus maxLength="9" placeholder="0000-0000"
            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">

            

            @error('telefono')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

       


        {{-- Rols --}}
        <label for="" class="form-label">Cargo</label>
        <div class="input-group mb-3">
       
            <select name="rol" id="rol" class="form-control @error('rol') is-invalid @enderror">
                    <option  value= "{{$user->roles[0]->name}}"  style="display:none">{{$user->roles[0]->name}}</option>
                @foreach($roles as $r)
                    <option  value= "{{ $r->name}}">{{$r->name}}</option>
                @endforeach
            </select>

            

            @error('rol')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        

        <br>

        {{-- Register button --}}
        <button type="submit"  class="btn btn-primary"   >
            <span class="fas fa-user-plus"></span>
            Guardar Datos
        </button>
      
        <a type="button" class="btn btn-danger" href="/listadousuario"  ><i class="fa fa-times" aria-hidden="true"></i>
           Cancelar
        </a>
<br>
<br>
    </form>

    <script>
        window.addEventListener('load',function(){
            document.getElementById('nacimiento').type= 'text';
            document.getElementById('nacimiento').addEventListener('blur',function(){
                document.getElementById('nacimiento').type= 'text';
            });
            document.getElementById('nacimiento').addEventListener('focus',function(){
                document.getElementById('nacimiento').type= 'date';
            });
        });
    </script>

@stop