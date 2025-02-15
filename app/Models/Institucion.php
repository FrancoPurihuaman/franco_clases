<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    use HasFactory;
    
    protected $table = "INSTITUCION";
    protected $primaryKey = 'ITC_CODIGO';
    
    const CREATED_AT = 'ITC_CREATED';
    const UPDATED_AT = 'ITC_UPDATED';
    
    
    /**
     * Obtener logo
     */
    public function getGetLogoAttribute() {
        if ($this->ITC_LOGO) {
            return url("storage/$this->ITC_LOGO");
        }
    }
    
}
