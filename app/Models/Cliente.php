<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nombre', 'correo', 'telefono'];


public function etiquetas()
    {
        return $this->belongsToMany(\App\Models\Etiqueta::class, 'cliente_etiqueta', 'cliente_id', 'etiqueta_id');
    }

}

