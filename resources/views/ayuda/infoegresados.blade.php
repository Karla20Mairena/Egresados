@extends('layouts.app')

@section('title', 'Instrucciónes Egresados')


@section('content')
<style>
  
    li{
        text-align: justify; 
        font-family: Open Sans, sans-serif; 
        font-size:15px;
        color:black;
    }
</style>

<ul>
<li><strong style="color:black; font-size:15px;">Vista Principal </strong> 
        <br>En este apartado se muestra una tabla, con la información de cada egresado que está registrado 
            en la base de datos, dentro de la misma tabla tenemos las acciones donde se encuentra: el botón 
            editar y eliminar que al momento de dar clic sobre ellos se hará la función correspondiente.</p>
             En la parte superior de la tabla tenemos:
        </li>
        <ol>
            <li>Un botón con el nombre Crear: este botón al momento de darle clic nos va a dirigir hacia un formulario, que nos va a solicitar llenar algunos campos para crear un nuevo egresado.</li>
            <li>Una lista desplegable: donde podemos seleccionar cuantos registros de los que se encuentran en la tabla, queremos que se nos muestre en la página actual, que nos encontremos en esa lista tenemos las siguientes opciones: (10, 25, 50 ó Todos). </li>
            <li>Tenemos cinco botones con el nombre de: (Copiar, Excel, CSV, PDF e Imprimir), dichos botones le permitirán descargar los reportes en diferentes formatos:</li>
            <ul>
                <li>Botón copiar: al momento de darle clic, lo que realiza es copiar la información de los egresados que se encuentran en la tabla, y permite pegar esa información donde usted desee. </li>
                <li>Botón Excel: cuando realice clic sobre él, se descargará un archivo (.xlsx) al momento de que usted le dé abrir a ese archivo se abrirá en Excel y este contendrá la información de los egresados. </li>  
                <li>Botón csv: este le descargará un archivo (.csv). Es un archivo de texto simple que se separan por coma y solo tienen letras y números, sirve para manejar una gran cantidad de datos en formato tabla. </li>
                <li>Botón pdf: al momento de darle clic le descarga un archivo (.pdf), cuando usted le dé clic en abrir archivo, le mostrara un documento con la información de los egresados. </li>
                <li>Botón imprimir: cuando usted de clic sobre él, lo va a dirigir hacia una pestaña donde le mostrará algunas opciones de configuraciones de impresión, cuando este todo listo deberá de darle clic al botón imprimir si desea, o cancelar para no realizar ninguna acción.  </li>
            </ul>
            </p>
            <li>Buscar: En la parte superior derecha tenemos un filtrado de búsqueda con el nombre de buscar, y a la par de su nombre un cuadro donde nos permite ingresar texto, números y caracteres especiales, esta acción facilita la búsqueda de información del egresado, permite restringir los resultados según criterios concretos, el contenido escrito en el cuadro de texto se va a buscar de acuerdo a la información que se encuentra en la base de datos.</li>
            <li>Rango: Este se encuentra a la par del filtrado de carreras. Es una recta donde muestra los años de egreso de cada estudiante, que ya ha finalizado su carrera, los años que se muestran en la parte inferior de la recta, son los años que están registrados en la base de datos, usted puede hacer clic sobre la recta o colocar el cursor mantenerlo pulsado y a arrastrarlo hacia el año donde desee, puede seleccionar cualquiera de los extremos de dicha recta, una vez que seleccione el rango de años le mostrara todos los egresados en esos años.</li>
        </ol>
        <br>
        <div  align ="center">
            <a href="http://egresados.test/egresado" target="_blank"><img style="width:700px;" alt="Image placeholder" src="{{asset('imagen/vistaprincipal.png')}}"></a>
        </div>



    <li><strong style="color:black; font-size:15px;">Crear Egresado </strong>
        <br>Esta vista nos muestra un formulario con los campos:(identidad, nombre completo, fecha de nacimiento, género, carrera y año de egreso), se debe de llenar cada uno de los campos mencionados con los datos correctos del egresado, una vez que se tiene completado el formulario debe de darle clic al botón Guardar, para que esa información esté en la base de datos si así lo desea, si le da clic al botón cancelar no se le guardara ninguna información  y lo llevara a la vista principal de egresados. </p>
    </li>
        <div  align ="center">
        <a href="http://egresados.test/egresado/create" target="_blank"><img style="width:700px;" alt="Image placeholder" src="{{asset('imagen/crear.png')}}"></a>
        </div>

    <li><strong style="color:black; font-size:15px;">Editar Egresado</strong>
        <br>Esta acción sirve por si se equivocó en algún dato del egresado, se ubica en el registro que va a corregir y da clic en el "botón editar", le mostrara un formulario con los datos guardados, corrige el dato y da clic en el "botón guardar cambios", se mostrara la vista principal de egresados con la información ya editada en la tabla, si le da clic en el "botón cancelar" no se le guardara ninguna información si realizo algún cambio y simplemente lo redirigirá a la vista principal de egresados.</p>
</li>
        <div  align ="center">
        <img style="width:700px;" alt="Image placeholder" src="{{asset('imagen/editar.png')}}">
        </div>

    <li><strong style="color:black; font-size:15px;">Eliminar Egresado</strong>
        <br>En la vista principal de egresados, se ubica en el registro que se desea eliminar y da clic en el botón eliminar registro, le aparecerá un mensaje de confirmación donde: le pregunta ¿si desea eliminar al egresado seleccionado?,si da clic en el botón “si” el registro se eliminará automáticamente de la base de datos, si da clic en el botón “no” el registro permanecerá en la base de datos.</p> 
    </li>
        <div  align ="center">
        <img style="width:700px;" alt="Image placeholder" src="{{asset('imagen/eliminar.png')}}">
        </div>
        <br>
        <br>
</ul>
    @endsection