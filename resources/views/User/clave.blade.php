@extends('layouts.app')

@section('title', 'Cambio contraseña')

@section('content')



<form action="" method="post">
        @csrf

    <center><h4></h4></center>
    <br>
    <br>
    <div class="input-group mb-3">
            <input type="password" name="viejapassword" class="form-control @error('viejapassword') is-invalid @enderror"
                   placeholder="Contraseña Actual">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('viejapassword')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

    

    {{-- Password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                   placeholder="Contraseña Nueva">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Confirm password field --}}
        <div class="input-group mb-3">
            <input type="password" name="password_confirmation"
                   class="form-control @error('password_confirmation') is-invalid @enderror"
                   placeholder="{{ __('Confirmar Contraseña Nueva') }}">

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                </div>
            </div>

            @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Register button --}}
        <button type="submit"  class="btn btn-primary" >
            <span class="fas fa-user-plus"></span>
            Guardar Cambios
        </button>
        
        <a type="button" class="btn btn-danger" href="./usuario" ><i class="fa fa-times" aria-hidden="true"></i>
            Cancelar
        </a>
    </form>

@stop