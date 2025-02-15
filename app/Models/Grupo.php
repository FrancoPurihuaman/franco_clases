<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;
    
    protected $table = "GRUPO";
    protected $primaryKey = 'GRP_CODIGO';
    
    const CREATED_AT = 'GRP_CREATED';
    const UPDATED_AT = 'GRP_UPDATED';
    
    
    /*
     * Metodo retorna colección de clases asociadas al grupo
     *
     * @return Illuminate\Database\Eloquent\Collection;
     */
    public function clases()
    {
        return $this->hasMany('App\Models\Clase', 'GRP_CODIGO');
    }
    
    /*
     * Metodo retorna colección de matriculas asociadas al grupo
     *
     * @return Illuminate\Database\Eloquent\Collection;
     */
    public function matriculas()
    {
        return $this->hasMany('App\Models\Matricula', 'GRP_CODIGO');
    }
    
    /*
     * Metodo retorna una instancia del "nivel" al que pertenece el grupo.
     *
     * @return App\Models\Nivel
     */
    public function nivel()
    {
        return $this->belongsTo('App\Models\Nivel', 'NIV_CODIGO', 'NIV_CODIGO');
    }
    
    /*
     * Metodo retorna una colección de estudiantes que pertenecen al grupo.
     *
     * @return Illuminate\Database\Eloquent\Collection;
     */
    public function estudiantes()
    {
        return $this->belongsToMany('App\Models\Estudiante', 'MATRICULA', 'GRP_CODIGO', 'STD_CODIGO');
    }
    
    /*
     * Metodo retorna una colección de areas que no fueron asignadas al grupo.
     *
     * @return Illuminate\Database\Eloquent\Collection;
     */
    public function areasNoAsignadas()
    {
        //$areasNoAsignadas = Area::whereNotExists(function ($query) {
        //    $query->select(DB::raw(1))
        //    ->from('CLASE')
        //    ->whereRaw('CLASE.ARE_CODIGO = AREA.ARE_CODIGO')
        //    ->where('CLASE.GRP_CODIGO', $this->GRP_CODIGO);
        //})->get();
        
        $areasNoAsignadas = Area::leftJoin('CLASE', function ($join) {
            $join->on('AREA.ARE_CODIGO', '=', 'CLASE.ARE_CODIGO')
            ->where('CLASE.GRP_CODIGO', '=', $this->GRP_CODIGO);
        })
        ->whereNull('CLASE.ARE_CODIGO')
        ->select('AREA.*')
        ->get();
        
        return $areasNoAsignadas;
    }
    
    /*
     * Metodo retorna la descripción de estado del grupo según el codigo de estado.
     *
     * @return String
     */
    public function getGetEstadoAttribute()
    {
        $estado = '';
        
        switch ($this->GRP_ESTADO) {
            case 0:
                $estado = 'cerrado';
                break;
            case 1:
                $estado = 'Activo';
                break;
            default:
                ;
            break;
        }
        
        return $estado;
    }
}
