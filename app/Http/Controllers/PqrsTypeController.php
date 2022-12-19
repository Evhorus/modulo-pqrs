<?php

namespace App\Http\Controllers;

use App\Models\PqrsType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PqrsTypeController extends Controller
{
    
    public function index()
    {
        $pqrsTypes = PqrsType::all();
        return response()->json($pqrsTypes);
    }

   
    public function store(Request $request)
    {
        $respuesta = array();
        $validar = $this->validar($request->all());
        if (!is_array($validar)) {
            PqrsType::create($request->all());
            array_push($respuesta, array(
                'status' => 'success',
            ));
            return response()->json($respuesta);
        }
        else {
            return response()->json($validar);
        }
    }

    
    public function show($id)
    {
        $pqrsTypes = PqrsType::find($id);
        return response()->json($pqrsTypes);
    }

    
    public function update(Request $request, $id)
    {
        $respuesta = array();
        $validar = $this->validar($request->all());
        if (!is_array($validar)){
            $pqrsTypes = PqrsType::find($id);
            if($pqrsTypes) {
                $pqrsTypes->fill($request->all())->save();
                array_push($respuesta, array('status' => 'success',));
            }
            else{
                array_push($respuesta, array('status'=> 'error'));
                array_push($respuesta, array('status'=>['id'=>'El id no existe']));
            }
            return response()->json($respuesta);
        }
        else {
            return response()->json($validar);
        }
    }
    
    public function destroy($id)
    {
        $respuesta = array();
        $pqrsTypes = PqrsType::find($id);
        if($pqrsTypes) {
            $pqrsTypes->delete();
            array_push($respuesta, array('status' => 'success',));
        }
        else{
            array_push($respuesta, array('status'=> 'error'));
            array_push($respuesta, array('status'=>['id'=>'El id no existe']));
        }
        return response()->json($respuesta);
    }

    public function validar ($parametros) {
        $respuesta = array();
        $menssages = array(
            'name.required' => 'El campo nombre es requerido',
            'name.max' => 'El campo nombre no puede tener mas de 250 caracteres',
        );
        $atributes = array(
            'name' => 'nombre',
        );
        $validacion = Validator::make($parametros, [
            'name' => 'required|max:250',
        ], $menssages, $atributes);
        if ($validacion->fails()) {
            array_push($respuesta, array('status' => 'error'));
            array_push($respuesta, array('status' => $validacion->errors()));
            return $respuesta;
        }
        else {
            return true;
        }
    }
}
