<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    use HasFactory;
    
    protected $table = "CLASE";
    protected $primaryKey = 'CLS_CODIGO';
    
    const CREATED_AT = 'CLS_CREATED';
    const UPDATED_AT = 'CLS_UPDATED';

    
    /*
     * Metodo retorna el área asociada a la clase
     *
     * @return App\Models\Area
     */
    public function area()
    {
        return $this->belongsTo('App\Models\Area', 'ARE_CODIGO', 'ARE_CODIGO');
    }
    
    /*
     * Metodo retorna el profesor asociado a la clase
     *
     * @return App\Models\Profesor
     */
    public function profesor()
    {
        return $this->belongsTo('App\Models\Profesor', 'PFS_CODIGO', 'PFS_CODIGO');
    }
    
    /*
     * Metodo retorna el grupo asociado a la clase
     *
     * @return App\Models\Grupo
     */
    public function grupo()
    {
        return $this->belongsTo('App\Models\Grupo', 'GRP_CODIGO', 'GRP_CODIGO');
    }
    
    /*
     * Metodo retorna colección de calificaciones asociadas a la clase
     *
     * @return Illuminate\Database\Eloquent\Collection;
     */
    public function calificaciones()
    {
        return $this->hasMany('App\Models\Calificacion', 'CLS_CODIGO');
    }
}
