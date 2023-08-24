@extends('layouts.app')
@section('title', 'Gráfico')
@section('content')

<style>
 h2,h5{
    
  text-align: center;
  font-family: Open Sans, sans-serif;
  
}
script{
  font-family: Open Sans, sans-serif;
}


</style>

<!DOCTYPE html>
<html>
<body>
    <script src="{{ asset("JS/sweetalert2.all.min.js") }}"></script>
    <script src="{{ asset("JS/app.js") }}"></script>
    <script src="{{asset('JS/plotly-latest.min.js')}}"></script>
    <script src="{{asset('JS/chart.js')}}"></script>

<div style="max-width: 95% !important;margin-left:1.5%">
<div class="row justify-content-center">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4" >
      <a href= "{{route('egresado.index')}}" style="text-decoration: none"> 
        <div class="card bg-gradient-primary">
            <div class="card-body p-2" >
                <div class="row" >
                    <div class="col-8">
                        <div class="numbers" style="color: white" >
                            <h2  style="color: white" >
                              Egresados
                            </h2>
                            <h5  style="color: white" >
                              {{$totalegresado}} Registrados
                            </h5>
                        </div>
                    </div>
                      <i class="fa fa-graduation-cap fa-3x" style="color:black"></i>
                </div>
            </div>
        </div>
      </a>
    </div>

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4" >
      <a href= "{{route('carreras.index')}}" style="text-decoration: none"> 
        <div class="card bg-gradient-primary">
            <div class="card-body p-2">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers" style="color: white" >
                            <h2 style="color: white" >
                              Carreras
                            </h2>
                            <h5  style="color: white" >
                              {{$totalcarrera}} Registradas
                            </h5>
                        </div>
                    </div>
                    <i class="fa fa-university fa-3x" style="color:black"></i> 
                </div>
            </div>
        </div>
      </a>
    </div>
</div>



<br><br>

<div style="float:left; width:45%;max-width:700px;border-style:solid;border-width: 2px;border-radius:.375rem;border-color:#7367E4;margin-bottom:30px;">
<div align ="center"  id="myPlot"  ></div>
</div>


<div align ="center" style="float:right; width:45%;max-width:700px;border-style:solid;border-width: 2px;border-radius:.375rem;border-color:#7367E4;margin-bottom:25px;">
<canvas id="myChart" style="width:500%;max-width:800px; height:450px " ></canvas>
</div>
</div>

  


<script>
 
var xArray = [
  @foreach ($graficos as $g)
     {{$g->año_egresado }},
     @endforeach
];
var yArray = [
  @foreach ($graficos as $g)
    {{$g->cantidad }},
    @endforeach
];

var Colors = [
  "#b91d47",
  "#00aba9",
  "#2b5797",
  "#e8c3b9",
  "#1e7145"
];

// Define Data
var data = [{
  backgroundColor: Colors,
  x: xArray,
  y: yArray,
  mode:"lines"
}];

// Define Layout
var layout = {
  xaxis: {range: [1976, (@if(isset($g->año_egresado)) {{$g->año_egresado}}+1 @else 2022 @endif)], title: "Año"},
  yaxis: {range: [1, (@if(isset($g->cantidad)) {{$g->cantidad}}+60 @else 10 @endif)], title: "Cantidad"},
  title:"<b>Egresados por Año</b>",
 
  
};


// Display using Plotly
Plotly.newPlot("myPlot", data, layout,{staticPlot:true});

</script>


<script>
var xValues = [
     @foreach ($graficarrera as $g)
     '{{$g->carrera }}',
     @endforeach];

var yValues = [
    @foreach ($graficarrera as $g)
    '{{$g->cantidad }}',
    @endforeach];

    
var barColors = [
  "#b91d47",
  "#00aba9",
  "#2b5797",
  "#e8c3b9",
  "#1e7145"
];


new Chart("myChart", {
  type: "pie",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    maintainAspectRatio: false,
    title: {
      display: true,
      text: "Carreras",
      fontSize: 20

    }
    
    
  }

});
</script>

@stop



