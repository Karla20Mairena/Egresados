<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class Egresado extends Model
{

    protected $fillable = [
        'nombre',
        'año_egresado',
        'fecha_nacimiento',
        'identidad',
        'nro_expediente',
        'gene_id',
        'carre_id',
    ];
    use HasFactory;
    
    public function carreras(){ 

        return $this->belongsTo( Carrera::class,'carre_id',"id");
    
    }


    public function genero()
    {
        return $this->belongsTo( Genero::class,'gene_id',"id");
    }
}
