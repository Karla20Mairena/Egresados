<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AyudaController extends Controller
{
    public function index(Request $request)
    {
        return view ('ayuda/ayudaindex');
    }

    public function egresados(Request $request)
    {
        return view ('ayuda/infoegresados');
    }

    public function infcarrera(Request $request)
    {
        return view ('ayuda/infocarreras');
    }

    public function usuario(Request $request)
    {
        return view ('ayuda/infousuario');
    }

    public function perfil(Request $request)
    {
        return view ('ayuda/infoperfil');
    }

    public function grafico(Request $request)
    {
        return view ('ayuda/infografico');
    }


 
    
}
