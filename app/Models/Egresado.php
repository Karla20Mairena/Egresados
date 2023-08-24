<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Egresado extends Model
{
    use HasFactory;
    
    public function carreras(){ 

        return $this->belongsTo( Carrera::class,'carre_id',"id");
    
    }


    public function genero()
    {
        return $this->belongsTo( Genero::class,'gene_id',"id");
    }
}
