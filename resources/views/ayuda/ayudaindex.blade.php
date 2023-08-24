@extends('layouts.app')

@section('title', 'Manual de Ayuda')


@section('content')
<style>

h2{
    
  text-align: center!important;
  font-family: Open Sans, sans-serif;
  margin-bottom: 15px;
  
   
}

</style>
<head>
<style>
 body{
overflow:hidden;
overflow-x:hidden;overflow-y:scroll;
overflow:-moz-scrollbars-vertical;
}
</style>
</head>
<div style="max-width: 100% !important;margin-left:1.5%">
<div class="row justify-content-center">
<div class="col-xl-3 col-sm-6 mb-xl-0 mb-4" >
<div  >
    
  </div>
  <br>   
      <a href= "{{route('info.grafico')}}" style="text-decoration: none"> 
        <div class="card bg-gradient-danger" >
            <div class="card-body p-1" align ="center">
            <br> 
            <img style="width:80%" alt="Image placeholder" src="{{asset('imagen/grafico.png')}}">
                <div class="row" style="justify-content: center;">
                    <div class="col-8 ">
                        <div  class="number" style="color:white;" >
                        <br>
                        <h2 style="color:white" >
                           Información Gráfico 
                        </h2>
                        </div>
                    </div>

                </div>
            </div>
        </div>
      </a>
    </div>
   




    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4" >
    <div  align ="center">
  </div>
  <br> 
      <a href= "{{route('info.egresados')}}" style="text-decoration: none"> 
        <div class="card bg-gradient-success">
            <div class="card-body p-1" align ="center" >
            <br>
            <img style="width:80%; height: 143px;" alt="Image placeholder" src="{{asset('imagen/egresados.jpg')}}">
                <div class="row" style="justify-content: center;">
                    <div class="col-8">
                        <div class="numbers" style="color: white" >
                        <br>
                            <h2  style="color: white" >
                               Información Egresados
                            </h2>
                            <h5 class="font-weight-bolder" style="color: white" >
                            
                            </h5>
                        </div>
                    </div>
                   
                </div>
                </div>
        </div>
      </a>
    </div>

    
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4" >
    <div  align ="center">
  </div>
  <br> 
      <a href= "{{route('info.carreras')}}" style="text-decoration: none"> 
        <div class="card bg-gradient-dark">
            <div class="card-body p-1"align ="center" >
              <br>
            <img style="width:80%; height: 143px;" alt="Image placeholder" src="{{asset('imagen/carrera.png')}}">
                <div class="row"style="justify-content: center;">
                    <div class="col-8">
                        <div class="numbers" style="color: white" >
                        <br>
                            <h2  style="color: white" >
                              Información Carreras
                            </h2>
                            <h5 class="font-weight-bolder" style="color: white" >
                              
                            </h5>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
      </a>
    </div>
    </div>
    <br>
    <br>
    </div>

  


    <div style="max-width:100% !important;margin-left:1.5%">
<div class="row justify-content-center">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4" >
    <div  align ="center">
   
  </div>
  <br> 
      <a href= "{{route('info.perfil')}}" style="text-decoration: none"> 
        <div class="card bg-gradient-info">
            <div class="card-body p-1"align ="center">
              <br>
            <img style="width:80%; height: 143px;" alt="Image placeholder" src="{{asset('imagen/perfil.png')}}">
                <div class="row"style="justify-content: center;">
                    <div class="col-8">
                        <div class="numbers" style="color: white" >
                        <br>
                            <h2 style="color: white" >
                              Información Perfil
                            <h5 class="font-weight-bolder" style="color: white" >
                              
                            </h5>
                        </div>
                    </div>
                  
                </div>
            </div>
        </div>
      </a>
    </div>
 
    

    @if(Auth::user()->id == 1)
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4" >
    <div  align ="center">
  
  </div>
  <br> 
      <a href= "{{route('info.usuario')}}" style="text-decoration: none"> 
        <div class="card bg-gradient-warning">
            <div class="card-body p-1" align ="center">
              <br>
            <img style="width:80%; height: 143px;" alt="Image placeholder" src="{{asset('imagen/usuarioss.png')}}">
                <div class="row"style="justify-content: center;">
                    <div class="col-8">
                        <div class="numbers" style="color: white" >
                        <br>
                            <h2 style="color: white" >
                              Información Usuario
                            </h2>
                            <h5 class="font-weight-bolder" style="color: white" >
                              
                            </h5>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
      </a>
    </div>
    @endif
 
</div>
<br> 
@endsection 