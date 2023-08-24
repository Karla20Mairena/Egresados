<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Rules\Contraactual;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function listado()
    {
      
        $usuarios = User::join('model_has_roles', 'users.id', '=','model_id')->where('role_id','>',1)->paginate(10);
        return view ('User.listado')->with('usuarios', $usuarios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function formularioclave()
    {
        return view ('User.clave');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardarclave(Request $request)
    {

        $rules=[
            'viejapassword' => ["required",new Contraactual],
            'password' => 'required|min:8|confirmed',
        ];

        $mensaje=[
            'viejapassword.required' => 'La contraseña no puede estar vacío',
            'viejapassword.Contractual' => 'La contraseña no coincide',
            'password.required' => 'La contraseña no puede estar vacío',
            'password.min' => 'La contraseña debe de tener mas de 8 caracteres',
            'password.confirmed' => 'La contraseña no coinciden',
        ];

        $this->validate($request,$rules,$mensaje);


        $contra = User::findOrFail(auth()->user()->id);
        $contra->password = Hash::make($request->input('password'));

        $contra->save();

        if($contra){
            return redirect('/')->with('mensaje', 'La contraseña fue actualizada exitosamente.');
        }else{
            //retornar con un mensaje de error.
        }

    }

    public function usuario(){
        return view('User.datos');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function registrar()
    {
        abort_if(Gate::denies('create_usuario'),redirect()->route('home')->with('denegar','No tiene acceso a esta sección'));

        $roles = Role::all();
        return view ('User.registrar', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $request)
    {
        $fecha_actual = date("d-m-Y");
        $max = date('d-m-Y',strtotime($fecha_actual."- 18 year"));
        $minima = date('d-m-Y',strtotime($fecha_actual."- 65 year"));
        $maxima = date("d-m-Y",strtotime($max."+ 1 days"));

        $rules=[
            'name' =>'required|regex:/^([A-Za-zÁÉÍÓÚáéíóúñÑ]+)(\s[A-Za-zÁÉÍÓÚáéíóúñÑ]+)*$/|max:100',
            'username' => 'required|min:8|unique:users,username',
            'correo' => 'required|max:100|email|unique:users,correo',
            'nacimiento'=>'required|date|before:'.$maxima.'|after:'.$minima,
            'identidad'=> 'required|unique:users,identidad|regex:([0-9]{4}-[0-9]{4}-[0-9]{5})',
            'telefono'=> 'required|regex:([0-9]{4}-[0-9]{4})',
            'password' => 'required|min:8|confirmed',
            'rol'=> 'required|exists:roles,name',
        ];

        $mensaje=[
            'name.required' => 'El nombre no puede estar vacío',

            'username.required' => 'El nombre de usuario no puede estar vacío',
            'username.min' => 'El nombre de usuario debe de tener mas de 8 caracteres',
            'username.unique' => 'El nombre de usuario ya esta en uso',

            'correo.required' => 'El correo electronico no puede estar vacío',
            'correo.max' => 'El correo electronico debe de tener menos de 100 caracteres',
            'correo.unique' => 'El correo electronico ya esta en uso',

            'nacimiento.required' => 'La fecha de nacimiento no puede estar vacío',
            'nacimiento.date' => 'La fecha de nacimiento debe de ser una fecha',
            'nacimiento.before' => 'La fecha de nacimiento debe de ser anterior a '.$maxima,
            'nacimiento.after' => 'La fecha de nacimiento debe de ser posterior a '.$minima,

            'identidad.required' => 'La identidad no puede estar vacío',
            'identidad.unique' => 'La identidad ya esta en uso',

            'telefono.required' => 'El telefono no puede estar vacío',
            'telefono.unique' => 'El telefono ya esta en uso',

            'password.required' => 'La contraseña no puede estar vacío',
            'password.min' => 'La contraseña debe de tener mas de 8 caracteres',
            'password.confirmed' => 'La contraseña no coinciden',

            'rol.required' => 'El cargo no puede estar vacío',
            'rol.exists' => 'El cargo no es valido',
        ];

        $this->validate($request,$rules,$mensaje);

        $user = new User();
        $user->name = $request->input('name');
        $user->correo = $request->input('correo');
        $user->nacimiento = $request->input('nacimiento');
        $user->identidad = $request->input('identidad');
        $user->telefono = $request->input('telefono');
        $user->username = $request->input('username');
        $user->password = Hash::make($request->input('password'));

        $user->assignRole($request->input('rol'));
        $user->save();

        if($user){
            return redirect('/listadousuario')->with('mensaje', 'El usuario fue creado exitosamente.');
        }else{
            //retornar con un mensaje de error.
        }

    }
    public function desactivar($id){
        $user = User::findOrFail($id);
        $user->estado = 0;
        $user->save();

        if($user){
            return redirect('/listadousuario')->with('mensaje', 'El usuario fue desactivado exitosamente.');
        }else{
            //retornar con un mensaje de error.
        }
    }

    public function activar($id){
        $user = User::findOrFail($id);
        $user->estado = 1;
        $user->save();

        if($user){
            return redirect('/listadousuario')->with('mensaje', 'El usuario fue activado exitosamente.');
        }else{
            //retornar con un mensaje de error.
        }
    }

      /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/listadousuario')->with('mensaje', 'Usuario fue borrado completamente');
    }

    public function editar(){

        return view('User.editardatos');
    }

    public function actualizar(Request $request){
        $fecha_actual = date("d-m-Y");
        $max = date('d-m-Y',strtotime($fecha_actual."- 18 year"));
        $minima = date('d-m-Y',strtotime($fecha_actual."- 65 year"));
        $maxima = date("d-m-Y",strtotime($max."+ 1 days"));

        $rules=[
           
                'name' =>'required|regex:/^([A-Za-zÁÉÍÓÚáéíóúñÑ]+)(\s[A-Za-zÁÉÍÓÚáéíóúñÑ]+)*$/|max:100',
                'username' => 'required|min:8|max:50',
                'correo' => 'required|max:100|email|',
                'nacimiento'=>'required|date|before:'.$maxima.'|after:'.$minima,
                'identidad'=> 'required|max:15|regex:([0-9]{4}-[0-9]{4}-[0-9]{5})',
                'telefono'=> 'required|regex:([0-9]{4}-[0-9]{4})',
        ];

        $mensaje=[
            'name.required' => 'El nombre no puede estar vacío',

            'username.required' => 'El nombre de usuario no puede estar vacío',
            'username.min' => 'El nombre de usuario debe de tener mas de 8 caracteres',
            

            'correo.required' => 'El correo electronico no puede estar vacío',
            'correo.max' => 'El correo electronico debe de tener menos de 100 caracteres',
            

            'nacimiento.required' => 'La fecha de nacimiento no puede estar vacío',
            'nacimiento.date' => 'La fecha de nacimiento debe de ser una fecha',
            'nacimiento.before' => 'La fecha de nacimiento debe de ser anterior a '.$maxima,
            'nacimiento.after' => 'La fecha de nacimiento debe de ser posterior a '.$minima,

            'identidad.required' => 'La identidad no puede estar vacío',
            

            'telefono.required' => 'El telefono no puede estar vacío',
            
        ];

        $this->validate($request,$rules,$mensaje);

        $user = User::find(auth()->user()->id);
        $user->name = $request->input('name');
        $user->correo = $request->input('correo');
        $user->nacimiento = $request->input('nacimiento');
        $user->identidad = $request->input('identidad');
        $user->telefono = $request->input('telefono');
        $user->username = $request->input('username');
        $user->save();

        return redirect('/usuario')->with('mensaje', 'El perfil fue modificado exitosamente');
    }


    //funcion de editar usuario

    public function editaru($id){


        abort_if(Gate::denies('create_usuario'),redirect()->route('home')->with('denegar','No tiene acceso a esta sección'));
       

        $roles = Role::all();
        $user = User::findOrfail($id);
        return view('User.editar', compact('roles'))->with('user', $user);
    }

    public function update(Request $request,$id){

        $fecha_actual = date("d-m-Y");
        $max = date('d-m-Y',strtotime($fecha_actual."- 18 year"));
        $minima = date('d-m-Y',strtotime($fecha_actual."- 65 year"));
        $maxima = date("d-m-Y",strtotime($max."+ 1 days"));

        $rules=[
            'name' =>'required|regex:/^([A-Za-zÁÉÍÓÚáéíóúñÑ]+)(\s[A-Za-zÁÉÍÓÚáéíóúñÑ]+)*$/|max:100',
            'username' => 'required|min:8|max:30',
            'correo' => 'required|max:100|email',
            'nacimiento'=>'required|date|before:'.$maxima.'|after:'.$minima,
            'identidad'=> 'required|regex:([0-9]{4}-[0-9]{4}-[0-9]{5})',
            'telefono'=> 'required|regex:([0-9]{4}-[0-9]{4})',
            'rol'=> 'required',
        ];

        $mensaje=[
            'name.required' => 'El nombre no puede estar vacío',

            'username.required' => 'El nombre de usuario no puede estar vacío',
            'username.min' => 'El nombre de usuario debe de tener mas de 8 caracteres',
            'username.unique' => 'El nombre de usuario ya esta en uso',

            'correo.required' => 'El correo electronico no puede estar vacío',
            'correo.max' => 'El correo electronico debe de tener menos de 100 caracteres',
            'correo.unique' => 'El correo electronico ya esta en uso',

            'nacimiento.required' => 'La fecha de nacimiento no puede estar vacío',
            'nacimiento.date' => 'La fecha de nacimiento debe de ser una fecha',
            'nacimiento.before' => 'La fecha de nacimiento debe de ser anterior a '.$maxima,
            'nacimiento.after' => 'La fecha de nacimiento debe de ser posterior a '.$minima,

            'identidad.required' => 'La identidad no puede estar vacío',
            'identidad.unique' => 'La identidad ya esta en uso',

            'telefono.required' => 'El telefono no puede estar vacío',
            'telefono.unique' => 'El telefono ya esta en uso',

            

            'rol.required' => 'El cargo no puede estar vacío',
            'rol.exists' => 'El cargo no es valido',
        ];

        $this->validate($request,$rules,$mensaje);

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->correo = $request->input('correo');
        $user->nacimiento = $request->input('nacimiento');
        $user->identidad = $request->input('identidad');
        $user->telefono = $request->input('telefono');
        $user->username = $request->input('username');
        if($user->roles[0]->name!=$request->input('rol')){
            $rols=DB::table('model_has_roles')->where('model_id', $id)->delete();
           
        $user->assignRole($request->input('rol'));
        }
        $user->save();

        if($user){
            return redirect('/listadousuario')->with('mensaje', 'El usuario fue modificado exitosamente.');
        }else{
            //retornar con un mensaje de error.
        }
    }

    
    
    



}