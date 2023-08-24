@extends('layouts.app')

@section('title', 'Instrucciónes Usuarios')


@section('content')
<style>
    li{
        text-align: justify; 
        font-family: Open Sans, sans-serif; 
        font-size:15px;
        color: black
    }

    h4{
        text-align: justify; 
        font-family: Open Sans, sans-serif; 
        font-size:18px;
    }
</style>
<ul>
<li>
<strong style="color:black; font-size:15px;">Listado de Usuario:</strong>
        <br>En este apartado se muestra una tabla con la información de cada usuario registrado en la base de datos, dentro de la misma tabla tenemos las acciones donde se encuentra el botón editar y activar o desactivar usuario, que al momento de dar clic sobre ellos se hará la función correspondiente y en la parte superior derecha de la tabla se muestra un botón de crear nuevos usuarios. Aclarando que en la tabla no se mostrara la información de los administradores solo se mostraran los datos del usuario en otras palabras “Digitador”.
</li>
<br>
        <div  align ="center">
            <a href="http://egresados.test/listadousuario" target="_black">
            <img style="width:700px;" alt="Image placeholder" src="{{asset('imagen/listadouusario.png')}}"></a>
        </div>


    <li><strong style="color:black; font-size:15px;">Crear Usuario:</strong>
        <br>Este botón, se encuentra en la vista principal de usuarios cuando usted haga clic sobre él, este lo va a dirigir hacia una nueva vista donde se encuentra un formulario con sus campos correspondientes:(Nombre completo, nombre de usuario, correo electrónico, número de identidad, fecha de nacimiento, número telefónico, cargo, contraseña),debe de llenar cada uno de los campos mencionados y dar clic sobre el "botón guardar datos", para que el nuevo usuario se registre en la base de datos y automáticamente deberá de aparecerle en la tabla de listado de usuario.</p>
    </li>
        <div  align ="center">
            <a href="http://egresados.test/registrar" target="_black">
            <img style="width:700px;" alt="Image placeholder" src="{{asset('imagen/creusuarios.png')}}"></a>
        </div>

        <div  align ="center">
            <img style="width:700px;" alt="Image placeholder" src="{{asset('imagen/crearusarios.png')}}">
        </div>

    <li><strong style="color:black; font-size:15px;">Editar Usuario:</strong>
        <br>Esta acción sirve, por si se equivocó en algún dato del usuario, se ubica en el registro que va a corregir y da clic en el botón editar, le mostrara un formulario con los datos ya guardados, corrige el dato correspondiente y da clic en el "botón guardar datos", se mostrara la vista principal de listado de usuario con la información ya editada, si le da clic en el "botón cancelar" no se le guardara ninguna información si realizo algún cambio y simplemente lo redirigirá a la vista principal de listado de usuario.  </p>
    </li>
        <div  align ="center">
            <img style="width:700px;" alt="Image placeholder" src="{{asset('imagen/editarusuario.png')}}">
        </div>
        
        <div  align ="center">
            <img style="width:700px;" alt="Image placeholder" src="{{asset('imagen/editusu.png')}}">
        </div>

    <li><strong style="color:black; font-size:15px;">Desactivar Usuario:</strong>
        <br>Cuando de clic sobre el botón, le aparecerá un mensaje de confirmación donde le preguntara si ¿Desea desactivar el usuario seleccionado?, si usted da clic en el botón “si” el usuario se desactivara, esto quiere decir que el usuario no podrá iniciar sesión con su cuenta en el sistema. </p> 
    </li>
        <div  align ="center">
            <img style="width:700px;" alt="Image placeholder" src="{{asset('imagen/desactivar.png')}}">
        </div>
        <br>

    <li><strong style="color:black; font-size:15px;">Activar Usuario:</strong>
        <br>Si el usuario está desactivado y usted desea activarlo, deberá de dar clic en el "botón activar usuario" le aparecerá un mensaje de confirmación ¿Desea activar al usuario seleccionado? Si da clic en el botón “si”, automáticamente la cuenta de ese usuario estará disponible para que la pueda utilizar en el sistema nuevamente. </p> 
    </li> 
        <div  align ="center">
            <img style="width:700px;" alt="Image placeholder" src="{{asset('imagen/activar.png')}}">
        </div>

        <br>
        <br>
</ul>
@endsection