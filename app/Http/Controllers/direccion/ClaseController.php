<?php

namespace App\Http\Controllers\direccion;

use Illuminate\Http\Request;
use App\Models\Clase;
use App\Traits\PaginatorLimitsFromTo;
use App\Http\Requests\direccion\ClaseRequest;
use App\Models\Grupo;
use App\Models\Profesor;

class ClaseController extends ModDireccionController
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
        $grupo          = $request->query('filter_grupo', '');
        $area        = $request->query('filter_area', '');
        $profesor           = $request->query('filter_profesor', '');
        
        // Condiciones para mostrar clase
        $oClase = new Clase();
        if ($codigo != '' && is_numeric($codigo) && $codigo >= 1) {
            $oClase = $oClase->where('CLS_CODIGO', '=', $codigo);
        }
        if($grupo != '' && is_numeric($grupo) && $grupo >= 1) {
            $oClase = $oClase->where('GRP_CODIGO', '=', $grupo);
        }
        if ($area != '' && is_numeric($area) && $area >= 1) {
            $oClase = $oClase->where('ARE_CODIGO', '=', $area);
        }
        if ($profesor != '' && is_numeric($profesor) && $profesor >= 1) {
            $oClase = $oClase->where('PFS_CODIGO', '=', $profesor);
        }
        
        
        // Obtener paginador y agregamos la cadena de consulta
        $pgdClases = $oClase->orderBy('CLS_CODIGO', 'desc')->paginate(25)->withQueryString();
        
        // Enviar valores de consulta
        $request->flash();
        
        return view('direccion.clase.claseLista', [
            'modulo' => $this->modulo,
            'pgdClases' => $pgdClases,
            'pgdClasesLimits' => $this->getPaginatorLimitsFromTo($pgdClases)
        ]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($idGrupo)
    {
        $oGrupo = Grupo::findOrFail($idGrupo);
        $areasNoAsignadas = $oGrupo->areasNoAsignadas();
        $profesores = Profesor::all();
        
        return view('direccion.clase.claseCrear', [
            'modulo' => $this->modulo,
            'grupo'  => $oGrupo,
            'areasNoAsignadas' => $areasNoAsignadas,
            'profesores' => $profesores
        ]);
        
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests
     * @return \Illuminate\Http\Response
     */
    public function store(ClaseRequest $request)
    {
        $oClase = new Clase();
        
        $oClase->GRP_CODIGO = $request->codigo;
        $oClase->ARE_CODIGO = $request->area;
        $oClase->PFS_CODIGO = $request->profesor;
        
        $oClase->save();
        
        return redirect()->route('clase.mostrar', [
            'id' => $oClase->CLS_CODIGO
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
        $oClase = Clase::findOrFail($id);
        
        return view('direccion.clase.claseMostrar', [
            'modulo'  => $this->modulo,
            'clase'    => $oClase
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
        return view('direccion.clase.claseEditar', [
            'modulo' => $this->modulo
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Inventario\ArticuloRequest
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClaseRequest $request, $id)
    {
        $oClase = Clase::findOrFail($id);
        
        $oClase->GRP_CODIGO = $request->codigo;
        $oClase->ARE_CODIGO = $request->area;
        $oClase->PFS_CODIGO = $request->profesor;
        
        $oClase->save();
        
        return redirect()->route('clase.mostrar', [
            'id' => $oClase->CLS_CODIGO
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
        $oClase = Clase::findOrFail($id);
        
        // Se eliminará la clase si no tiene alguna calificación asociada
        if(is_null($oClase->calificaciones()->first())){
            
            $oClase->delete();
            
            return redirect()->route('clase.lista')->with('status', [
                'type'      => 'success',
                'message'   => 'Eliminado exitosamente!!'
            ]);
        }else{
            
            return back()->with('status', [
                'type'      => 'error',
                'message'   => 'Clase no puede ser eliminada'
            ]);
        }
    }
}
