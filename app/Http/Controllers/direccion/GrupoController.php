<?php

namespace App\Http\Controllers\direccion;

use App\Http\Requests\direccion\GrupoRequest;
use App\Traits\PaginatorLimitsFromTo;
use Illuminate\Http\Request;
use App\Models\Nivel;
use App\Models\Grupo;

class GrupoController extends ModDireccionController
{
    use PaginatorLimitsFromTo;
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $codigo         = $request->query('filter_ref', '');
        $nivel          = $request->query('filter_nivel', '');
        $seccion        = $request->query('filter_seccion', '');
        $year           = $request->query('filter_year', '');
        $mes            = $request->query('filter_mes', '');
        $estado         = $request->query('filter_estado', '');
        
        // Condiciones para mostrar grupo
        $oGrupo = new Grupo();
        if ($codigo != '' && is_numeric($codigo) && $codigo >= 1) {
            $oGrupo = $oGrupo->where('GRP_CODIGO', '=', $codigo);
        }
        if($nivel != '') {
            $oGrupo = $oGrupo->where('NIV_CODIGO', '=', $nivel);
        }
        if ($seccion != '') {
            $oGrupo = $oGrupo->where('GRP_SECCION', '=', $seccion);
        }
        if($year != '' && is_numeric($year) ) {
            $oGrupo = $oGrupo->whereYear('GRP_FECHA_INICIO', '=', $year);
        }
        if($mes != '' && is_numeric($mes) ) {
            $oGrupo = $oGrupo->whereMonth('GRP_FECHA_INICIO', '=', $mes);
        }
        if($estado != '' && is_numeric($estado) ) {
            $oGrupo = $oGrupo->where('GRP_ESTADO', '=', $estado);
        }else{$oGrupo = $oGrupo->where('GRP_ESTADO', '=', 1);}
        
        
        // Obtener paginador y agregamos la cadena de consulta
        $pgdGrupos = $oGrupo->orderBy('GRP_CODIGO', 'desc')->paginate(25)->withQueryString();
        
        // Enviar valores de consulta
        $request->flash();
        
        // Enviar datos para filtros
        $niveles = Nivel::all();
        
        return view('direccion.grupo.grupoLista', [
            'modulo' => $this->modulo,
            'pgdGrupos' => $pgdGrupos,
            'pgdGruposLimits' => $this->getPaginatorLimitsFromTo($pgdGrupos),
            'niveles'         => $niveles
        ]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $niveles = Nivel::all();
        
        return view('direccion.grupo.grupoCrear', [
            'modulo' => $this->modulo,
            'niveles' => $niveles
        ]);
        
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests
     * @return \Illuminate\Http\Response
     */
    public function store(GrupoRequest $request)
    {
        $oGrupo = new Grupo();
        
        $oGrupo->NIV_CODIGO = $request->nivel;
        $oGrupo->GRP_SECCION = $request->seccion;
        $oGrupo->GRP_FECHA_INICIO = $request->fecha_inicio;
        $oGrupo->GRP_FECHA_CIERRE = $request->fecha_cierre;
        $oGrupo->GRP_TIPO_PERIODO = $request->tipo_periodo;
        $oGrupo->GRP_TOTAL_PERIODOS = $request->total_periodos;
        $oGrupo->GRP_PERIODO_ACTUAL = 1;
        $oGrupo->GRP_ESTADO = 1;
        
        $oGrupo->save();
        
        return redirect()->route('grupo.mostrar', [
            'id' => $oGrupo->GRP_CODIGO
        ])->with('status', [
            'type'      => 'success',
            'message'   => 'Creado exitosamente!!'
        ]);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $oGrupo = Grupo::findOrFail($id);
        
        return view('direccion.grupo.grupoMostrar', [
            'modulo'    => $this->modulo,
            'grupo'     => $oGrupo
        ]);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $oGrupo = Grupo::findOrFail($id);
        $niveles = Nivel::all();
        
        return view('direccion.grupo.grupoEditar', [
            'modulo' => $this->modulo,
            'grupo' => $oGrupo,
            'niveles' => $niveles
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Inventario\ArticuloRequest
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GrupoRequest $request, $id)
    {
        $oGrupo = Grupo::findOrFail($id);
        
        $oGrupo->NIV_CODIGO = $request->nivel;
        $oGrupo->GRP_SECCION = $request->seccion;
        $oGrupo->GRP_FECHA_INICIO = $request->fecha_inicio;
        $oGrupo->GRP_FECHA_CIERRE = $request->fecha_cierre;
        $oGrupo->GRP_TIPO_PERIODO = $request->tipo_periodo;
        $oGrupo->GRP_TOTAL_PERIODOS = $request->total_periodos;
        $oGrupo->GRP_PERIODO_ACTUAL = $request->periodo_actual;
        $oGrupo->GRP_ESTADO = $request->estado;
        
        $oGrupo->save();
        
        return redirect()->route('grupo.mostrar', [
            'id' => $oGrupo->GRP_CODIGO
        ])->with('status', [
            'type'      => 'success',
            'message'   => 'Actualizado exitosamente!!'
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $oGrupo = Grupo::findOrFail($id);
        
        // Se eliminará el grupo si no tiene alguna matricula o clase asociada
        if(is_null($oGrupo->matriculas()->first()) && is_null($oGrupo->clases()->first())){
            
            $oGrupo->delete();
            
            return redirect()->route('grupo.lista')->with('status', [
                'type'      => 'success',
                'message'   => 'Eliminado exitosamente!!'
            ]);
        }else{
            
            return back()->with('status', [
                'type'      => 'error',
                'message'   => 'Grupo no puede ser eliminado'
            ]);
        }
    }
}
