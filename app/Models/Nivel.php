<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    use HasFactory;
    
    protected $table = "NIVEL";
    protected $primaryKey = 'NIV_CODIGO';
    
    const CREATED_AT = 'NIV_CREATED';
    const UPDATED_AT = 'NIV_UPDATED';
    
    /*
     * Metodo retorna colección grupos asociados al nivel
     *
     * @return Illuminate\Database\Eloquent\Collection;
     */
    public function grupos()
    {
        return $this->hasMany('App\Models\Grupo', 'NIV_CODIGO');
    }
}
