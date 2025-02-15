<?php

namespace App\Http\Requests\direccion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class ClaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'clases'            => 'required|array|min:1',
            'clases.*'          => 'string'
        ];
    }
    
    /**
     * Método con validador adicional (después de la validación principal)
     *
     * @param \Illuminate\Validation\Validator $validator
     */
    public function withValidator($validator)
    {
        // Esto se ejecuta después de que las reglas iniciales de validación se hayan evaluado
        // Nota: Los valores deben estar en el siguiente formato: ["grupo:valor,area:valor,profesor:valor",...]
        
        $validator->after(function ($validator) {
            
            foreach ($this->clases as $clase) {
                
                $datos = explode(',', $clase);
                $datosArray = [];
                
                // Verificamos que haya exactamente 3 valores
                if (count($datos) !== 3) {
                    // Si no hay 3 valores, añadimos un error al validador
                    $validator->errors()->add('clases', 'Cada clase debe contener exactamente tres valores: Grupo, area, profesor');
                    return;
                }
                
                // Convertimos el array de string "clave:valor" a un array associativo
                $errorFormato = false;
                foreach ($datos as $dato) {
                    $parKeyValue = explode(':', $dato);
                    if (count($parKeyValue) !== 2) {
                        // Si no hay 2 valores (clave:valor), indicamos que hay error en el formato 
                        $errorFormato = true;
                        return;
                    }
                    $datosArray[$parKeyValue(0)] = $parKeyValue(1);
                }
                
                // Verificamos si hay algun error en el formato de los valores
                if (!$errorFormato) {
                    // Si hay algun error de formato, añadimos un error al validador
                    $validator->errors()->add('clases', 'Los datos de cada clase deben enviarse en el formato: clave:valor');
                    return;
                }
                
                
                // Verificamos si existen las claves necesarias
                if (!array_key_exists("grupo", $datosArray)) {
                    // Si no existe la llave grupo, añadimos un error al validador
                    $validator->errors()->add('clases', 'El identificador del grupo el necesario');
                    return;
                }
                if (!array_key_exists("area", $datosArray)) {
                    // Si no existe la llave area, añadimos un error al validador
                    $validator->errors()->add('clases', 'El identificador del area el necesario');
                    return;
                }
                if (!array_key_exists("profesor", $datosArray)) {
                    // Si no existe la llave profesor, añadimos un error al validador
                    $validator->errors()->add('clases', 'El identificador del profesor el necesario');
                    return;
                }
                
                
                // Verificamos la existencia de cada ID en la tabla correspondiente
                if (!DB::table('GRUPO')->where('GRP_CODIGO', $datosArray['grupo'])->exists()) {
                    $validator->errors()->add('clases', "El identificador de la tabla grupo ({$datosArray['grupo']}) no existe.");
                }
                if (!DB::table('AREA')->where('ARE_CODIGO', $datosArray['area'])->exists()) {
                    $validator->errors()->add('clases', "El identificador de la tabla area ({$datosArray['area']}) no existe.");
                }
                if (!DB::table('PROFESOR')->where('PFS_CODIGO', $datosArray['profesor'])->exists()) {
                    $validator->errors()->add('clases', "El identificador de la pofesor ({$datosArray['profesor']}) no existe.");
                }
            }
        });
    }
}
