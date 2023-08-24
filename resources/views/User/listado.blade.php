@extends('layouts.app')

@section('title', 'Listado de usuario')

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

<div align="right" style="float:right">
    <a href="./registrar"  class="btn btn-info"><i class="fa fa-user-plus" aria-hidden="true"></i> Crear Usuario</a>
    </div>
    <br>
    <br>
    <br>
<table class = "table table-sm table-bordered">
<thead class="thead-dark">
        <tr>
            <th style="font-size:15px;text-align:center" scope="col">No</th>
            <th style="font-size:15px;text-align:center" scope="col">Nombre</th>
            <th style="font-size:15px;text-align:center" scope="col">Usuario</th>
            <th style="font-size:15px;text-align:center" scope="col">Correo electrónico</th>
            <th style="font-size:15px;text-align:center" scope="col">Teléfono</th>
            <th style="font-size:15px;text-align:center" scope="col">Identidad</th>
            
            
            <th style="font-size:15px;text-align:center" scope="col">Acciones</th>
            
        </tr>
    </thead>

    <tbody>
        @foreach ($usuarios as $m=>$users)
       
        <tr>
            <td style="font-size:15px;text-align:right" class="align-middle" scope="row">{{++$m + ($usuarios->perPage()*($usuarios->currentPage()-1))}}</td>
            <td style="font-size:15px"class="align-middle"  >{{$users->name}}</td>
            <td style="font-size:15px"class="align-middle" >{{$users->username}}</td>
            <td style="font-size:15px"class="align-middle"  >{{$users->correo}}</td>
            <td style="font-size:15px" class="align-middle">{{$users->telefono}}</td>
            <td style="font-size:15px" class="align-middle">{{$users->identidad}}</td>
           
           

            <td>
              <div align="center">
                @if($users->estado == 1)
                
                  
                <a type="button"  title="Editar registro" href=" /usuario/{{$users->id}}/edit"class="btn btn-info" >
                <i class="fas fa-pencil-alt" aria-hidden="true"></i></a>

                   <button type="bottom"  onClick="desactivar{{$users->id}}()" title="Desactivar Usuario " class="btn btn-success">
                    <i class="fa fa-eye" aria-hidden="true"></i></button>
                <form action="{{route('user.desactivar',['id'=>$users->id])}}"  id="desac{{$users->id}}">     
                </div>
               <script>
                function desactivar{{$users->id}}(){
                    Swal.fire({
  title: 'Desactivar Usuario',
  text: '¿Desea desactivar al usuario seleccionado?',
  icon: 'question',
  showCancelButton: true,
  confirmButtonText: 'Si',
  cancelButtonText: `No`,
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.value) {
    document.getElementById('desac{{$users->id}}').submit();
  } else {
    
  }
})
                }

                </script>

               </form>
                @else
                
                    <button type="bottom"  onClick="activar{{$users->id}}()" title="Activar Usuario " class="btn btn-primary">
                    <i class="fa fa-eye-slash" aria-hidden="true"></i> </button>
                <form action="{{route('user.activar',['id'=>$users->id])}}"  id="act{{$users->id}}">     
              
               <script>
                function activar{{$users->id}}(){
                    Swal.fire({
  title: 'Activar Usuario',
  text: '¿Desea activar al usuario seleccionado?',
  icon: 'question',
  showCancelButton: true,
  confirmButtonText: 'Si',
  cancelButtonText: `No`,
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.value) {
    document.getElementById('act{{$users->id}}').submit();
  } else {
    
  }
})
                }

                </script>

               </form>
                @endif

                
               </form>
            </td>
        </tr>
     
        @endforeach
    </tbody>
</table>
{{$usuarios->links()}}
@stop