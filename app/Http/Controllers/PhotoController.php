<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Humano;
use Faker\Provider\ar_EG\Person;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PhotoController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $humanos = Humano::all();
        $response = Http::withToken('oat_Mg.YjI5OF8wVHdJb0JWVktWZ0dYdTlmMDUyc1JXazlPT1VzM215TU5vNzEwNTQ1NjUwMDc')
        ->timeout(80)
        ->get('http://localhost:3333/mascotas');
        
        $datasa = $response->json();

        return response()->json([
            "msgs" => "Lista de Humanos",
            "humanos" => $humanos,
            "mascotasa" => $datasa
        ], 200);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // Validación de datos de entrada
        $validate = Validator::make($request->all(), [
            "nombre" => 'required|string|min:3|max:255',
            "edad" => 'required|numeric',
            "apellido_paterno" => 'required|string',
            "apellido_materno" => 'required|string',
            "phone" => 'required|numeric',
            "email" => 'required|email',
        ]);

        // Si la validación falla, se devuelve un mensaje de error
        if ($validate->fails()) {
            return response()->json([
                "msg" => "Error en validación",
                "error" => $validate->errors(),  // Corrección: errors(), no message()
            ], 422);
        }

        // Crear una nueva instancia de Humano
        $humano = new Humano();
        $humano->nombre = $request->nombre;
        $humano->apellido_paterno = $request->apellido_paterno;
        $humano->apellido_materno = $request->apellido_materno;
        $humano->edad = $request->edad;
        $humano->phone = $request->phone;
        $humano->email = $request->email;

        // Guardar la instancia en la base de datos
        $humano->save();

        // Respuesta exitosa
        return response()->json([
            "msg" => "Datos almacenados correctamente",
            "data" => $humano,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $humanos = Humano::find($id);

        // Verificar si existe el registro
        if (!$humanos) {
            return response()->json([
                "msges" => "Humano no encontrado",
            ], 404);
        }

        return response()->json([
            "msges" => "Detalles del Humano",
            "resultado" => $humanos,
        ], 200);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Buscar el registro
        $humano = Humano::find($id);

        // Verificar si existe
        if (!$humano) {
            return response()->json([
                "msg" => "Humano no encontrado",
            ], 404);
        }

        // Validación de datos de entrada
        $validate = Validator::make($request->all(), [
            "nombre" => 'required|string|min:3|max:255',
            "edad" => 'required|numeric',
            "apellido_paterno" => 'required|string',
            "apellido_materno" => 'required|string',
            "phone" => 'required|numeric',
            "email" => 'required|email',
        ]);

        // Si la validación falla
        if ($validate->fails()) {
            return response()->json([
                "msg" => "Error en validación",
                "error" => $validate->errors(),
            ], 422);
        }

        // Actualizar los datos del Humano
        $humano->nombre = $request->nombre;
        $humano->apellido_paterno = $request->apellido_paterno;
        $humano->apellido_materno = $request->apellido_materno;
        $humano->edad = $request->edad;
        $humano->phone = $request->phone;
        $humano->email = $request->email;

        // Guardar los cambios
        $humano->save();

        // Respuesta exitosa
        return response()->json([
            "msg" => "Datos actualizados correctamente",
            "data" => $humano,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Buscar el registro
        $humano = Humano::find($id);

        // Verificar si existe
        if (!$humano) {
            return response()->json([
                "msg" => "Humano no encontrado",
            ], 404);
        }

        // Eliminar el registro
        $humano->delete();

        // Respuesta exitosa
        return response()->json([
            "msg" => "Humano eliminado correctamente",
        ], 200);
    }
}
