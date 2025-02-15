<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\direccion\AreaController;
use App\Http\Controllers\direccion\ClaseController;
use App\Http\Controllers\direccion\CompetenciaController;
use App\Http\Controllers\direccion\EstudianteController;
use App\Http\Controllers\direccion\InstitucionController;
use App\Http\Controllers\direccion\NivelController;
use App\Http\Controllers\direccion\ProfesorController;
use App\Http\Controllers\academia\LibretaController;
use App\Http\Controllers\direccion\DireccionHomeController;
use App\Http\Controllers\academia\AcademiaHomeController;
use App\Http\Controllers\direccion\GrupoController;


// Menu principal de modulos --------------------------------------------------------------------
Route::get('/', function () { return view('modulos'); })->middleware('auth')->name('modulos.index');



// Modulo direccion ------------------------------------------------------------------

Route::get('/direccion', [DireccionHomeController::class, 'index'])->middleware('auth')->name('direccion.home');


// Institución *********************

// Institución -> formulario crear
Route::get('/direccion/institucion/crear', [InstitucionController::class, 'create'])->middleware('auth')->name('institucion.crear');

// Institución -> guardar
Route::post('/direccion/institucion/guardar', [InstitucionController::class, 'store'])->middleware('auth')->name('institucion.guardar');

// Institución -> mostrar
Route::get('/direccion/institucion/mostrar', [InstitucionController::class, 'show'])->middleware('auth')->name('institucion.mostrar');

// Institución -> formulario editar
Route::get('/direccion/institucion/editar', [InstitucionController::class, 'edit'])->middleware('auth')->name('institucion.editar');

// Institución -> Actualizar
Route::put('/direccion/institucion/actualizar', [InstitucionController::class, 'update'])->middleware('auth')->name('institucion.actualizar');


// Profesor *********************

// Profesor -> lista
Route::get('/direccion/profesor/lista', [ProfesorController::class, 'index'])->middleware('auth')->name('profesor.lista');

// Profesor -> formulario crear
Route::get('/direccion/profesor/crear', [ProfesorController::class, 'create'])->middleware('auth')->name('profesor.crear');

// Profesor -> guardar
Route::post('/direccion/profesor/guardar', [ProfesorController::class, 'store'])->middleware('auth')->name('profesor.guardar');

// Profesor -> mostrar
Route::get('/direccion/profesor/{id}/mostrar', [ProfesorController::class, 'show'])->middleware('auth')->name('profesor.mostrar');

// Profesor -> formulario editar
Route::get('/direccion/profesor/{id}/editar', [ProfesorController::class, 'edit'])->middleware('auth')->name('profesor.editar');

// Profesor -> Actualizar
Route::put('/direccion/profesor/{id}/actualizar', [ProfesorController::class, 'update'])->middleware('auth')->name('profesor.actualizar');

// Profesor -> eliminar
Route::delete('/direccion/profesor/{id}/eliminar', [ProfesorController::class, 'destroy'])->middleware('auth')->name('profesor.eliminar');


// Estudiante *********************

// Estudiante -> lista
Route::get('/direccion/estudiante/lista', [EstudianteController::class, 'index'])->middleware('auth')->name('estudiante.lista');

// Estudiante -> formulario crear
Route::get('/direccion/estudiante/crear', [EstudianteController::class, 'create'])->middleware('auth')->name('estudiante.crear');

// Estudiante -> guardar
Route::post('/direccion/estudiante/guardar', [EstudianteController::class, 'store'])->middleware('auth')->name('estudiante.guardar');

// Estudiante -> mostrar
Route::get('/direccion/estudiante/{id}/mostrar', [EstudianteController::class, 'show'])->middleware('auth')->name('estudiante.mostrar');

// Estudiante -> formulario editar
Route::get('/direccion/estudiante/{id}/editar', [EstudianteController::class, 'edit'])->middleware('auth')->name('estudiante.editar');

// Estudiante -> Actualizar
Route::put('/direccion/estudiante/{id}/actualizar', [EstudianteController::class, 'update'])->middleware('auth')->name('estudiante.actualizar');

// Estudiante -> eliminar
Route::delete('/direccion/estudiante/{id}/eliminar', [EstudianteController::class, 'destroy'])->middleware('auth')->name('estudiante.eliminar');


// Area *********************

// Area -> lista
Route::get('/direccion/area/lista', [AreaController::class, 'index'])->middleware('auth')->name('area.lista');

// Area -> formulario crear
Route::get('/direccion/area/crear', [AreaController::class, 'create'])->middleware('auth')->name('area.crear');

// Area -> guardar
Route::post('/direccion/area/guardar', [AreaController::class, 'store'])->middleware('auth')->name('area.guardar');

// Area -> mostrar
Route::get('/direccion/area/{id}/mostrar', [AreaController::class, 'show'])->middleware('auth')->name('area.mostrar');

// Area -> formulario editar
Route::get('/direccion/area/{id}/editar', [AreaController::class, 'edit'])->middleware('auth')->name('area.editar');

// Area -> Actualizar
Route::put('/direccion/area/{id}/actualizar', [AreaController::class, 'update'])->middleware('auth')->name('area.actualizar');

// Area -> eliminar
Route::delete('/direccion/area/{id}/eliminar', [AreaController::class, 'destroy'])->middleware('auth')->name('area.eliminar');


// Competencia *********************

// Competencia -> lista
Route::get('/direccion/competencia/lista', [CompetenciaController::class, 'index'])->middleware('auth')->name('competencia.lista');

// Competencia -> formulario crear
Route::get('/direccion/competencia/crear', [CompetenciaController::class, 'create'])->middleware('auth')->name('competencia.crear');

// Competencia -> guardar
Route::post('/direccion/competencia/guardar', [CompetenciaController::class, 'store'])->middleware('auth')->name('competencia.guardar');

// Competencia -> mostrar
Route::get('/direccion/competencia/{id}/mostrar', [CompetenciaController::class, 'show'])->middleware('auth')->name('competencia.mostrar');

// Competencia -> formulario editar
Route::get('/direccion/competencia/{id}/editar', [CompetenciaController::class, 'edit'])->middleware('auth')->name('competencia.editar');

// Competencia -> Actualizar
Route::put('/direccion/competencia/{id}/actualizar', [CompetenciaController::class, 'update'])->middleware('auth')->name('competencia.actualizar');

// Competencia -> eliminar
Route::delete('/direccion/competencia/{id}/eliminar', [CompetenciaController::class, 'destroy'])->middleware('auth')->name('competencia.eliminar');


// Nivel *********************

// Nivel -> lista
Route::get('/direccion/nivel/lista', [NivelController::class, 'index'])->middleware('auth')->name('nivel.lista');

// Nivel -> formulario crear
Route::get('/direccion/nivel/crear', [NivelController::class, 'create'])->middleware('auth')->name('nivel.crear');

// Nivel -> guardar
Route::post('/direccion/nivel/guardar', [NivelController::class, 'store'])->middleware('auth')->name('nivel.guardar');

// Nivel -> mostrar
Route::get('/direccion/nivel/{id}/mostrar', [NivelController::class, 'show'])->middleware('auth')->name('nivel.mostrar');

// Nivel -> formulario editar
Route::get('/direccion/nivel/{id}/editar', [NivelController::class, 'edit'])->middleware('auth')->name('nivel.editar');

// Nivel -> Actualizar
Route::put('/direccion/nivel/{id}/actualizar', [NivelController::class, 'update'])->middleware('auth')->name('nivel.actualizar');

// Nivel -> eliminar
Route::delete('/direccion/nivel/{id}/eliminar', [NivelController::class, 'destroy'])->middleware('auth')->name('nivel.eliminar');



// Grupo *********************

// Grupo -> lista
Route::get('/direccion/grupo/lista', [GrupoController::class, 'index'])->middleware('auth')->name('grupo.lista');

// Grupo -> formulario crear
Route::get('/direccion/grupo/crear', [GrupoController::class, 'create'])->middleware('auth')->name('grupo.crear');

// Grupo -> guardar
Route::post('/direccion/grupo/guardar', [GrupoController::class, 'store'])->middleware('auth')->name('grupo.guardar');

// Grupo -> mostrar
Route::get('/direccion/grupo/{id}/mostrar', [GrupoController::class, 'show'])->middleware('auth')->name('grupo.mostrar');

// Grupo -> formulario editar
Route::get('/direccion/grupo/{id}/editar', [GrupoController::class, 'edit'])->middleware('auth')->name('grupo.editar');

// Grupo -> Actualizar
Route::put('/direccion/grupo/{id}/actualizar', [GrupoController::class, 'update'])->middleware('auth')->name('grupo.actualizar');

// Grupo -> eliminar
Route::delete('/direccion/grupo/{id}/eliminar', [GrupoController::class, 'destroy'])->middleware('auth')->name('grupo.eliminar');


// Clase *********************

// Clase -> lista
Route::get('/direccion/clase/lista', [ClaseController::class, 'index'])->middleware('auth')->name('clase.lista');

// Clase -> formulario crear
Route::get('/direccion/grupo/{idGrupo}/clase/crear', [ClaseController::class, 'create'])->middleware('auth')->name('clase.crear');

// Clase -> guardar
Route::post('/direccion/clase/guardar', [ClaseController::class, 'store'])->middleware('auth')->name('clase.guardar');

// Clase -> mostrar
Route::get('/direccion/clase/{id}/mostrar', [ClaseController::class, 'show'])->middleware('auth')->name('clase.mostrar');

// Clase -> formulario editar
Route::get('/direccion/clase/{id}/editar', [ClaseController::class, 'edit'])->middleware('auth')->name('clase.editar');

// Clase -> Actualizar
Route::put('/direccion/clase/{id}/actualizar', [ClaseController::class, 'update'])->middleware('auth')->name('clase.actualizar');

// Clase -> eliminar
Route::delete('/direccion/clase/{id}/eliminar', [ClaseController::class, 'destroy'])->middleware('auth')->name('clase.eliminar');


// Modulo academia ------------------------------------------------------------------

Route::get('/academia', [AcademiaHomeController::class, 'index'])->middleware('auth')->name('academia.home');


// Modulo reportes ------------------------------------------------------------------

// Libretas
Route::get('/academia/reportes/libretas', [LibretaController::class, 'index'])->middleware('auth')->name('reporte.libreta');

Route::get('/academia/reportes/libretas/estudiante/{idClase}', [LibretaController::class, 'porEstudiante'])->middleware('auth')->name('reporte.libreta.estudiante');
