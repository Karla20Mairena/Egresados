@extends('layouts.app')

@section('title', 'Egresados')


@section('content')
<style>
     .range-label{
        position: absolute !important;
        margin-top: -52px !important;
        margin-left: -630% !important;
        color:black;
    }
    .irs--flat{
        position: absolute !important;
        margin-top: -102px !important;
        width: 765% !important;
        margin-left: -490% !important;
    }
       .dt-buttons button{
        margin-left: 1vh !important;
        border-radius: 5px 5px 5px 5px !important;
        border: none !important;
        width: auto;
    }
    .dataTables_length{
        margin-right: 2vh;
        margin-bottom: 10vh;
      
    }
    .select-filter{
        position: absolute;
        margin-top: -90px;
        margin-left:-75vh ;
    }
   .dataTables_filter
   {
    margin-right:-6vh !important;
}
</style>

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

<div class="contrainer">
</div>
    <div align="right" style="float:right">
    <a href="egresado/create" title="Crear Registro" class="btn btn-info"><i class='fas fa-file-medical'></i>  Crear</a>
    </div>
<br>
<br>
<br>
<table id="mitabla"  class = "table table-sm table-bordered ">
<thead  class="thead-dark">
<tr>
            <th style="font-size:15px;text-align:center; width:45px;"  scope="col">No</th>
            <th style="font-size:15px;text-align:center; width:135px;"   scope="col">Identidad</th>
            <th style="font-size:15px;text-align:center; width:250px;"  scope="col">Nombre Completo</th>
            <th style="font-size:15px;text-align:center; width:340px;"  scope="col">Carrera</th>
            <th style="font-size:15px;text-align:center; width:40px;"  scope="col">Año</th>
            
            
            <th style="font-size:15px;text-align:center;width:125px;"  scope="col">Acciones</th>
            
        </tr>
    </thead>

    <tbody>
    @php $n=0; @endphp

        @foreach ($egresados as  $egresado)
        <tr>
            
            <td class="align-middle" style="font-size:13px; text-align:right" scope="row">{{++ $n}}</td>
            <td class="align-middle" style="font-size:13px" >{{$egresado->identidad}}</td>
            <td class="align-middle" style="font-size:13px" >{{$egresado->nombre}}</td>
            <td class="align-middle" style="font-size:13px">{{$egresado->carreras->Carrera}}</td>
            <td class="align-middle" style="font-size:13px">{{$egresado->año_egresado}}</td>
           
           

            <td>
            <a type="button"  title="Editar registro" href="./egresado/{{$egresado->id}}/edit" class="btn btn-info" >
                <i class="fas fa-pencil-alt" aria-hidden="true"></i></a>
                <button type="bottom"  onClick="borrar{{$egresado->id}}()" title="Eliminar registro" class="btn btn-danger">
               <i class="fa fa-window-close" aria-hidden="true"></i></button>
                <form action="{{route ('egresado.destroy',$egresado->id)}}" method="POST" id="eliminar{{$egresado->id}}"> 
                
                @csrf
                @method('DELETE')       
               
               <script>
                function borrar{{$egresado->id}}(){
                    Swal.fire({
  title: 'Eliminar Egresado',
  text: '¿Desea eliminar al egresado seleccionado?',
  icon: 'error',
  showCancelButton: true,
  confirmButtonText: 'Si',
  cancelButtonText: `No`,
}).then((result) => {
  /* Read more about isConfirmed, isDenied below */
  if (result.value) {
    document.getElementById('eliminar{{$egresado->id}}').submit();
  } else {
    
  }
})
                }

                </script>

               </form>
             </td>
        </tr>

        @endforeach
    </tbody>

  </table>
  

  <script>
    
const fechaActual = new Date();
        const dia = fechaActual.getDate();
        const mes = fechaActual.getMonth() + 1;
        const anio = fechaActual.getFullYear();
        const horas = fechaActual.getHours();
        const minutos = fechaActual.getMinutes();
        const segundos = fechaActual.getSeconds();

        const fechaLarga = `${dia}_${mes}_${anio} ${horas}_${minutos}_${segundos}`;
        const fechaCorta = `${dia}/${mes}/${anio}`;
        var tituloDocumento = 'Cosme García C ' + '\n' +  '\n' +  'Egresados de la fecha ' + fechaCorta  + '\n' + ' Importado por ' +'{{auth()->user()->name}}';
       

        $(document).ready(function() {
            $('#mitabla').DataTable({
                dom: 'lBfrtip',
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                rowCallback: function(row, data, index) {
                // Agregue el índice autoincrementable a la primera celda de la fila
                $('td:eq(0)', row).html(index + 1);
                },       
       language: {
                    "lengthMenu": "Mostrar _MENU_ resultados",
                    "zeroRecords": "No se encontraron resultados",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay resultados disponibles",
                    "infoFiltered": "(filtrado de _MAX_ total registros)",
                    "search": '<i class="fa fa-search" aria-hidden="true"></i> Buscar',
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                // botón copiar
                buttons: [
                    {
                        extend: 'copyHtml5',
                        text: '<i class="fa fa-copy"></i> Copiar',
                        className: 'bg-info',
                        title: function() {
                            return tituloDocumento; // Obtener título actualizado
                        },
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4],
                            format: {
                                header: function (title, idx, cellIdx) {
                                    if (idx === 3) {
                                        return 'Carrera';
                                    } else if (idx === 4) {
                                        return 'Año egresado';
                                    } else  {
                                        return title;
                                    }
                                },
                                body: function (data, row, column, node) {
                                    if (column === 0) {
                                        return row + 1;
                                    } else {
                                        return data;
                                    }
                                }
                            }
                        }
                    },

                       // botón excel
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-table" aria-hidden="true"></i> Excel',
                        className: 'bg-success',
                        title: function() {
                            return tituloDocumento; // Obtener título actualizado
                        },
                        exportOptions: {
                            columns: [0, 1, 2, 3,4],
                            format: {
                                header: function (title, idx, cellIdx) {
                                    if (idx === 3) {
                                        return 'Carrera';
                                    } else if (idx === 4) {
                                        return 'Año egresado';
                                    } else  {
                                        return title;
                                    }
                                },
                                body: function (data, row, column, node) {
                                    if (column === 0) {
                                        return row + 1;
                                    } else {
                                        return data;
                                    }
                                }
                            }
                        }
                    },
                       // botón csv
                    {
                        extend: 'csvHtml5',
                        text: '<i class="fa fa-database" aria-hidden="true"></i> CSV',
                        className: 'bg-warning',
                        title: function() {
                            return tituloDocumento; // Obtener título actualizado
                        },
                        exportOptions: {
                            columns: [0, 1, 2, 3,4],
                            format: {
                                header: function (title, idx, cellIdx) {
                                    if (idx === 3) {
                                        return 'Carrera';
                                    } else if (idx === 4) {
                                        return 'Egreso';
                                    } else  {
                                        return title;
                                    }
                                }
                            }
                        },
                        customize: function(csv) {
                                var lines = csv.split('\n');
                                var line;
                                for (var i = 1; i < lines.length; i++) {
                                    line = lines[i].split(',');
                                    line[0] = i;
                                    lines[i] = line.join(',');
                                }
                                return lines.join('\n');
                            },
                    },

                       // botón pdf
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file" aria-hidden="true"></i> PDF',
                        className: 'bg-danger',
                        title: function() {
                            return tituloDocumento; // Obtener título actualizado
                        },
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4],
                            format: {
                                header: function(title, idx, cellIdx) {
                                    if (idx === 3) {
                                        return 'Carrera';
                                    } else if (idx === 4) {
                                        return 'Año egresado';
                                    } else {
                                        return title;
                                    }
                                }
                            }
                        },
                        // Obtener número de pagina
                        customize: function(doc) {
                            doc['footer']=(function(page, pages) {
                                return {
                                    columns: [{
                                        alignment: 'center',
                                        text: [{ 
                                            text: page.toString(), italics: true
                                        },
                                        ' de ',
                                        { text: pages.toString(), italics: true }
                                        ]
                                    }],
                                    margin: [10, 0]
                                }
                            });
                            var table = doc.content[1].table;
                            for (var i = 1; i < table.body.length; i++) {
                                table.body[i][0].text = {text: i, alignment: 'right'};
                            }
                            doc.content[1].layout = {
                                hLineWidth: function() { return 0.5; },
                                vLineWidth: function() { return 0.5; },
                                hLineColor: function() { return '#aaa'; },
                                vLineColor: function() { return '#aaa'; },
                                paddingLeft: function() { return 10; },
                                paddingRight: function() { return 10; },
                                width: 'auto'
                            };
                        }
                    },

                       // botón imprimir
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print" aria-hidden="true"></i> Imprimir',
                        className: 'bg-primary',
                        title: function() {
                            return tituloDocumento; // Obtener título actualizado
                        },
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4],
                            format: {
                                header: function (title, idx, cellIdx) {
                                    if (idx === 3) {
                                        return 'Carrera';
                                    } else if (idx === 4) {
                                        return 'Año egresado';
                                    } else  {
                                        return title;
                                    }
                                },
                                body: function(data, row, column, node) {
                                if (column === 0) {
                                return row+1;
                    
                                } else {
                                return data;
                                }
                              }
                            } 
                        },
                        customize: function(win) {
                            $(win.document.body).find('td:nth-child(1)').css('text-align', 'right');
                        },
                       
                        onTable: function() {
                            $(this).DataTable().columns.adjust();
                        }
            
                    }
                ],

                  // filtro de las carreras
                initComplete: function () {
                    this.api().columns().every(function () {
                        var column = this;
                        // agregamos filtro solo para las columnas 3 y 4
                        if (column.index() === 3 ) {
                            var select = $('<select class="form-control select-filter" id="carrera"><option value="">Seleccione una carrera</option></select>')
                                .appendTo($(column.header()))
                                .on('change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );
                                    column.search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                                        if ($('#rango').val()) {
                                        tituloDocumento = 'Cosme García C ' + '\n' + 'Egresados de la carrera ' + $('#carrera').val() + '\n'+' del año ' + $('#rango').data().from + ' al ' + $('#rango').data().to +'\n'+ ' Importado por ' +'{{auth()->user()->name}}';
                                    } else {
                                        tituloDocumento = 'Cosme García C ' + '\n' + 'Egresados de la carrera ' + $('#carrera').val() + '\n'+ ' año ' + fechaCorta + '\n'+' Importado por ' +'{{auth()->user()->name}}';
                                    }
                                    // Actualizar título del documento
                                    $('title').text(tituloDocumento);

                                });
                            column.data().unique().sort().each(function (d, j) {
                                select.append('<option value="' + d + '">' + d + '</option>')
                            });
                        }
                       

                       
                            //Rango de año
                        if (column.index() === 4) {
                           
                            //se definen los datos de inicio y final
                            
                            var min = {{$egresados->pluck('año_egresado')->min()-1}};
                            var max = {{$egresados->pluck('año_egresado')->max()+1}};
                            //se crea el input reange
                            var slider = $('<input type="text" class="range-slider range-slider" id="rango"/>');
                            var label = $('<label class="range-label" for="rango">Rango:</label>');
                            $(column.header()).append(label, slider);
                            slider.ionRangeSlider({
                                    type: "double",
                                    min: min,
                                    max: max,
                                    from: min,
                                    to: max,
                                    grid: true,
                                    onFinish: function (data) {
                                        // Obtener los valores mínimo y máximo del rango
                                        var minVal = parseInt(data.from);
                                        var maxVal = parseInt(data.to);
                                        var buscador = minVal;
                                        //rellenar un arreglo para realizar la busqueda
                                        for (let index = minVal+1; index <= maxVal; index++) {
                                            var buscador = buscador+'|'+index;
                                            
                                        }
                                        // Filtrar los datos de la columna
                                        column.search(buscador, true, false).draw();
                                        if ($('#carrera').val()) {
                                            tituloDocumento = 'Cosme García C ' + '\n' + 'Egresados de la carrera ' + $('#carrera').val() + '\n'+' del año ' + minVal + ' al ' + maxVal +'\n'+ ' Importado por ' +'{{auth()->user()->name}}';
                                        } else {
                                            tituloDocumento = 'Cosme García C ' + '\n' + 'Egresados del año ' + minVal + ' al ' + maxVal +'\n'+ ' Importado por ' +'{{auth()->user()->name}}';
                                        }
                                
                                        // Actualizar título del documento
                                        $('title').text(tituloDocumento);
                                    }
                                });
                                
                        }
                    });
                }
            });
        });
  </script>

 

@endsection 