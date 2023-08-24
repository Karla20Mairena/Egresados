@extends('layouts.app')

@section('title', 'Instrucciónes Gráfico')


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
<li><strong style="color:black; font-size:15px;">Gráfico Egresados</strong>
        <br>En el gráfico de egresados por años: Se muestra del lado izquierdo las cantidades de egresados que hay por año y el lado inferior el año en que se graduaron, este diseño es lineal donde, se va a mostrar de una manera resumida todos los egresados que hay registrados en la base de datos.</p>
</li>

        <li><strong style="color:black; font-size:15px;">Gráfico Carreras</strong>
        <br>Se muestra los egresados por carreras, divididos en colores distintos por cada segmento.</p>
</li>
<li><strong style="color:black; font-size:15px;">Card</strong>
        <br>En la parte superior de los gráficos, tenemos dos tarjetas: una de egresados donde al darle clic nos llevara, donde esta toda la información de los egresados registrados en la base de datos y la otra tarjeta de carreras donde al darle clic, nos mostrara una vista donde están las carreras registradas en la base de datos. </p>
</li>
    <br>
    <div  align ="center">
        <a href="http://egresados.test/" target="_blank"> <img style="width:700px;" alt="Image placeholder" src="{{asset('imagen/card.png')}}"></a>
    </div>
</ul>
@endsection