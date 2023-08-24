@extends('layouts.app')

@section('title', 'Instrucciónes Carreras')


@section('content')

<style>
    li{
        text-align: justify; 
        font-family: Open Sans, sans-serif; 
        font-size:15px;
        color: black
    }
</style>

<ul>
    <li><strong style="color:black; font-size:15px;">Vista Principal</strong>
        <br>En esta vista se muestra una tabla con información de las carreras, que están en la base de datos, muestra una acción de editar carrera que al momento de darle clic, nos llevara a otra vista y en la parte superior derecha de la tabla tenemos: un botón de "crear carreras" que una vez dando clic sobre él nos va a dirigir hacia otra vista.
    </li>
    <br>
        <div  align ="center">
            <a href="http://egresados.test/carreras" target="_black">
            <img style="width:700px;" alt="Image placeholder" src="{{asset('imagen/vistacarrera.png')}}"></a >
        </div>

    <li><strong style="color:black; font-size:15px;">Crear Carreras </strong>
        <br>Este botón se encuentra en la vista principal de carreras, al hacer clic sobre él nos va a dirigir hacia otra vista donde nos muestra un pequeño formulario, con un campo que debemos llenar que es el, “Nombre de la carrera”, se debe hacer clic en el "botón Guardar" y automáticamente esta carrera estará registrada en la base de datos y se debe mostrar en la tabla de la vista principal de carrera, si hace clic en el "botón cancelar", no guardara ninguna información simplemente le mostrara le vista principal de carreras.  
    </li> 
    <br>
        <div  align ="center">
            <a href="http://egresados.test/carreras/create"  target="_black">
            <img style="width:700px;" alt="Image placeholder" src="{{asset('imagen/crearcarrera.png')}}"></a>
        </div>

    <li><strong style="color:black; font-size:15px;">Editar Carreras </strong>
        <br>En la vista principal se ubica en el registro que desea modificar y hace clic en el "botón editar", se le debe mostrar una vista con un pequeño formulario y la información guardada, realiza el cambio correspondiente y hace clic en el "botón guardar cambios", ese cambio se le debe mostrar en la vista principal de carreras. Si hace clic en el "botón cancelar" le mostrara la vista principal de carreras. 
    </li> 
    <br>
        <div  align ="center">
            <img style="width:700px;" alt="Image placeholder" src="{{asset('imagen/editarcarrera.png')}}">
        </div>
        <br>
        <br>
</ul>

@endsection