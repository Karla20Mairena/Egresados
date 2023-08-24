<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\EgresadoController;
use App\Http\Controllers\CarreraController;
use App\Models\Egresado;
use App\Models\Carrera;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $graficos = Egresado::select('año_egresado', DB::raw('count(*)as cantidad'))->groupby ('año_egresado')->orderby('año_egresado')->get();
       

        $graficarrera = Carrera::select('carrera', DB::raw('count(*)as cantidad'))
        ->join ('egresados', 'carreras.id', '=', 'egresados.carre_id')
        ->groupby ('carrera')->orderby('carrera')->get();
        $totalegresado = Egresado::all()->count();
        $totalcarrera = Carrera::all()->count();
        return view('welcome')->with('graficos', $graficos)->with('graficarrera', $graficarrera)->with('totalegresado', $totalegresado)->with('graficarrera', $graficarrera)->with('totalcarrera', $totalcarrera);
        

    }
}
