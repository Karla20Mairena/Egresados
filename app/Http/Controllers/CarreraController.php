<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrera;

class CarreraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carreras = Carrera::all();
        return view('carreras.index')-> with('carreras', $carreras);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('carreras.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules=[
            'carrera'=>'required|regex:/^([A-Za-zÁÉÍÓÚáéíóúñÑ]+)(\s[A-Za-zÁÉÍÓÚáéíóúñÑ]+)*$/|max:70|min:5|unique:carreras,carrera',
        ];

        $mensaje=[
            'carrera.required'=>'El campo :attribute es obligatorio.',
            'carrera.regex'=>'El campo :attribute solo acepta letras.',
            'carrera.max'=>'El campo :attribute no debe de pasar los 100 caracteres.',
            'carrera.min'=>'El campo :attribute debe de tener al menos 5 caracteres.',
        ];

        $this->validate($request,$rules,$mensaje);

        $carreras = new Carrera();
        $carreras->carrera = $request->get('carrera');

        $carreras->save();

        if( $carreras){
            return redirect('/carreras')->with('mensaje', 'La carrera fue creada exitosamente.');
        }else{
            //retornar con un mensaje de error.
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $carrera = Carrera::findOrfail($id);
        return view('carreras.edit')->with('carrera',$carrera);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        
        $request->validate([
        
            'carrera'=>'required|regex:/^([A-Za-zÁÉÍÓÚáéíóúñÑ]+)(\s[A-Za-zÁÉÍÓÚáéíóúñÑ]+)*$/|max:100',
            
        ]);

        $carrera = Carrera::find($id);

        $carrera->carrera = $request->get('carrera');

        $carrera->save();

        if($carrera){
            return redirect('/carreras')->with('mensaje', 'La carrera fue Modificada exitosamente.');
        }else{
            //retornar con un mensaje de error.
        }

    
    }
 
}