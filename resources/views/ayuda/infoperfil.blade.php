@extends('layouts.app')

@section('title', 'Instrucciónes Perfil')


@section('content')
<style>
    p{
        text-align: justify; 
        font-family: Open Sans, sans-serif; 
        font-size:15px;
        color: black;
    }
    li{
        text-align: justify; 
        font-family: Open Sans, sans-serif; 
        font-size:15px;
        color: black;
    }
</style>


<ul> 
    <li>
        <strong style="color:black; font-size:15px;">Datos del Usuario:</strong> 
        <br>En la parte superior, lado derecho, aparece un icono y a la par el nombre del usuario que está utilizando la cuenta, deberá de dar clic sobre el nombre o el icono se desplegaran tres: opciones si desea ver sus datos seleccione la "opción perfil", automáticamente lo llevara a una vista donde, se le mostrara un formulario con sus datos registrados en la base de datos, si da clic en el botón “Volver a Inicio” este lo va a llevar a la vista Gráficos. 
    </li>
        <br>
        <div  align ="center">
            <a href="http://egresados.test/usuario" target="_blank"> 
            <img style="width:700px;" alt="Image placeholder" src="{{asset('imagen/datos.png')}}"></a>
        </div>


    <li><strong style="color:black; font-size:15px;">Editar Datos del Usuario:</strong> 
        <br>Si usted desea editar los datos que se le muestran, en la parte inferior del formulario,(Datos del usuario) le aparecen tres opciones: “Editar”, “Cambiar contraseña” y “Volver al inicio”, deberá de dar clic en el botón Editar, este lo llevara a una vista llamada "Editar Perfil" donde se muestra un formulario con los datos guardados en la base de datos, se ubica en el campo que desea editar, lo corrige y seguidamente puede dar clic en el "botón Guardar Cambios" y automáticamente el sistema lo va a dirigir a la vista Datos del Usuario con las modificaciones ya guardaras.       </li>
        <br> 
        <div  align ="center">
            <img style="width:700px;" alt="Image placeholder" src="{{asset('imagen/editarperfil.png')}}">
        </div>


    <li><strong style="color:black; font-size:15px;">Cambiar Contraseña:</strong> 
        <br> Para poder cambiar su contraseña, en la vista Datos del Usuario, deberá de dar clic en el "botón Cambiar contraseña", el sistema lo va a dirigir hacia una vista llamada “Cambio de Contraseña”, se le mostrará un pequeño formulario con los campos:(Contraseña actual, Contraseña nueva y confirmar contraseña nueva), una vez complete los campos con los datos adecuados o cumpla los requisitos requeridos y de clic en el botón “Guardar Cambios”, la nueva contraseña se actualizará en la base de datos. También puede acceder desde la parte superior lado derecho del sistema da clic, en el nombre del usuario o en el icono una vez que se le desplieguen las opciones: selecciona “Cambiar Contraseña” y se mostrara la vista correspondiente (Cambio de Contraseña).      </li>
        <br> 
        <div  align ="center">
            <a href="http://egresados.test/contrasenia" target="_blank"><img style="width:700px;" alt="Image placeholder" src="{{asset('imagen/contra.png')}}"></a>
        </div>
    

    <li><strong style="color:black; font-size:15px;">Cerrar Sesión: </strong> <br>Esta opción se encuentra en la parte superior lado derecho, da clic en el icono o en el nombre que aparece, una vez se le muestren las opciones, da clic en el botón “Cerrar Sesión”, se va a finalizar el acceso al sistema y automáticamente se va a mostrar el inicio de sesión del sistema.       </li>
        <br>
        <div  align ="center">
            <img style="width:700px;" alt="Image placeholder" src="{{asset('imagen/sesion.png')}}">
        </div>
    

</ul>

@endsection