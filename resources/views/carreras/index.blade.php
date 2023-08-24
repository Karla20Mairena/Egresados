@extends('layouts.app')

@section('title', 'Carreras')

@section('content')

<script>
    var msg = '{{Session::get('mensaje')}}';
    var exist = '{{Session::has('mensaje')}}';
    if(exist){
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: msg,
            showConfirmButton: false,
            toast: true,
            background: '#0be004ab',
            timer: 3500
        })
    }

</script>

<script>
    function quitarerror(){
    const elements = document.getElementsByClassName('alert');
    while (elements[0]){
        elements[0].parentNode.removeChild(elements[0]);
    }
}

setTimeout(quitarerror, 3000);
</script>
<br>
<div align="right">
 <a href="carreras/create" title="Crear registro" class="btn btn-info"><i class='fas fa-file-medical'></i> Crear</a>
</div>
<br>


<table class = "table table-sm table-bordered">

    <thead class="thead-dark"  >
        <tr>
            <th style="font-size:15px; text-align:center" scope="col">No</th>
            <th style="font-size:15px; text-align:center" scope="col">Carrera</th>
            <th style="font-size:15px; text-align:center" scope="col">Acciones</th>
        </tr>
    </thead>

    <tbody>
        
    @foreach ($carreras as $n=>$carrera)
        <tr>
            <td class="align-middle" style="font-size:15px; text-align:right"  scope="row">{{++$n }}</td>
       
            <td class="align-middle" style="font-size:15px">{{$carrera->Carrera}}</td>

            <td>
                <form action="{{route ('carreras.destroy',$carrera->id )}}" method="POST"> 
                <a type="button" href="./carreras/{{$carrera->id}}/edit" class="btn btn-info" title="Editar Carrera">
                <i class="fas fa-pencil-alt" aria-hidden="true"></i></a>
                @csrf
              
                </form>
            </td>
        </tr>
        
        @endforeach
    </tbody>
</table>



@endsection 