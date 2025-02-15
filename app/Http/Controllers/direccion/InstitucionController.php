<?php

namespace App\Http\Controllers\direccion;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Institucion;
use App\Http\Requests\direccion\InstitucionRequest;

class InstitucionController extends ModDireccionController
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $oInstitucion = Institucion::first();
        
        if ($oInstitucion) {
            return redirect()->route('institucion.mostrar');
            
        }else{
            return view('direccion.institucion.institucionCrear', [
                'modulo' => $this->modulo
            ]);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests
     * @return \Illuminate\Http\Response
     */
    public function store(InstitucionRequest $request)
    {
        $oInstitucion = new Institucion();
        
        $oInstitucion->ITC_CODIGO_MODULAR = $request->codigo_modular;
        $oInstitucion->ITC_NOMBRE = $request->nombre;
        $oInstitucion->ITC_DIRECTOR = $request->director;
        
        if($request->hasFile('logo')){
            $oInstitucion->ITC_LOGO = $request->file('logo')->store('institucion', 'public');
        }
        
        $oInstitucion->save();
        
        return redirect()->route('institucion.mostrar', [
            'id' => $oInstitucion->ITC_CODIGO
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
    public function show()
    {
        $oInstitucion = Institucion::first();
        
        if ($oInstitucion) {
            return view('direccion.institucion.institucionMostrar', [
                'modulo'        => $this->modulo,
                'institucion'      => $oInstitucion
            ]);
        }else{
            return redirect()->route('institucion.crear');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $oInstitucion = Institucion::firstOrFail();
        
        return view('direccion.institucion.institucionEditar', [
            'modulo' => $this->modulo,
            'institucion' => $oInstitucion
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Inventario\ArticuloRequest
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InstitucionRequest $request)
    {
        $oInstitucion = Institucion::firstOrFail();
        
        $oInstitucion->ITC_CODIGO_MODULAR = $request->codigo_modular;
        $oInstitucion->ITC_NOMBRE = $request->nombre;
        $oInstitucion->ITC_DIRECTOR = $request->director;
        
        if($request->hasFile('logo')){
            Storage::disk('public')->delete($oInstitucion->ITC_LOGO);
            $oInstitucion->ITC_LOGO = $request->file('logo')->store('institucion', 'public');
        }
        
        $oInstitucion->save();
        
        return redirect()->route('institucion.mostrar', [
            'id' => $oInstitucion->ITC_CODIGO
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
        //
    }
}
