<?php

namespace App\Http\Requests\direccion;

use Illuminate\Foundation\Http\FormRequest;

class GrupoRequest extends FormRequest
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
            'nivel'                         => 'required|numeric|exists:NIVEL,NIV_CODIGO',
            'seccion'                       => 'required|max:20',
            'fecha_inicio'                  => 'required|date',
            'fecha_cierre'                  => 'required|date',
            'tipo_periodo'                  => 'required|max:20',
            'total_periodos'                => 'required|numeric',
            'periodo_actual'                => 'required|numeric',
            'estado'                        => 'required|in:0,1'
        ];
    }
}
