<?php

namespace App\Http\Controllers\direccion;

use App\Traits\PaginatorLimitsFromTo;
use Illuminate\Http\Request;
use App\Http\Requests\direccion\NivelRequest;
use App\Models\Nivel;

class NivelController extends ModDireccionController
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
        $nombre         = $request->query('filter_nombre', '');
        
        // Condiciones para mostrar nivel
        $oNivel = new Nivel();
        if ($codigo != '' && is_numeric($codigo) && $codigo >= 1) {
            $oNivel = $oNivel->where('NIV_CODIGO', '=', $codigo);
        }
        if($nombre != '') {
            $oNivel = $oNivel->where('NIV_NOMBRE', 'LIKE', $nombre.'%');
        }
        
        // Obtener paginador y agregamos la cadena de consulta
        $pgdNiveles = $oNivel->orderBy('NIV_CODIGO', 'desc')->paginate(25)->withQueryString();
        
        // Enviar valores de consulta
        $request->flash();
        
        return view('direccion.nivel.nivelLista', [
            'modulo' => $this->modulo,
            'pgdNiveles' => $pgdNiveles,
            'pgdNivelesLimits' => $this->getPaginatorLimitsFromTo($pgdNiveles)
        ]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('direccion.nivel.nivelCrear', [
            'modulo' => $this->modulo
        ]);
        
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests
     * @return \Illuminate\Http\Response
     */
    public function store(NivelRequest $request)
    {
        $oNivel = new Nivel();
        
        $oNivel->NIV_NOMBRE = strtolower($request->nombre);
        $oNivel->NIV_DESCRIPCION = $request->descripcion;
        
        $oNivel->save();
        
        return redirect()->route('nivel.mostrar', [
            'id' => $oNivel->NIV_CODIGO
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
        $oNivel = Nivel::findOrFail($id);
        
        return view('direccion.nivel.nivelMostrar', [
            'modulo'  => $this->modulo,
            'nivel'    => $oNivel
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
        $oNivel = Nivel::findOrFail($id);
        
        return view('direccion.nivel.nivelEditar', [
            'modulo' => $this->modulo,
            'nivel' => $oNivel
        ]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Inventario\ArticuloRequest
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NivelRequest $request, $id)
    {
        $oNivel = Nivel::findOrFail($id);
        
        $oNivel->NIV_NOMBRE = strtolower($request->nombre);
        $oNivel->NIV_DESCRIPCION = $request->descripcion;
        
        $oNivel->save();
        
        return redirect()->route('nivel.mostrar', [
            'id' => $oNivel->NIV_CODIGO
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
        $oNivel = Nivel::findOrFail($id);
        
        // Se eliminará el nivel si no tiene algun grupo asociado
        if(is_null($oNivel->grupos()->first())){
            
            $oNivel->delete();
            
            return redirect()->route('nivel.lista')->with('status', [
                'type'      => 'success',
                'message'   => 'Eliminado exitosamente!!'
            ]);
        }else{
            
            return back()->with('status', [
                'type'      => 'error',
                'message'   => 'Nivel no puede ser eliminado'
            ]);
        }
    }
}
