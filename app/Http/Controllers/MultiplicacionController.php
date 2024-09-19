<?php

namespace App\Http\Controllers;

use App\Models\Humano;
use App\Models\Persona;
use Faker\Provider\ar_EG\Person;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Nette\Utils\Strings;

class MultiplicacionController extends Controller
{
    public function tablasMultiplicar($numero1 = 0, $numero2 = 0, $limiteFibonacci = '')
    {
        if ($limiteFibonacci === 'fibonacci') {
            // Generamos las tablas de ambos números

            $fibonacci = $this->generarFibonacci($numero2);

            return response()->json([
                'fibonacci' => $fibonacci
            ], 200);
        }

        // Si los números son iguales, solo generamos una tabla
        if ($numero1 == $numero2) {
            $tabla = $this->generarTablaMultiplicar($numero1);
            $fibonacci = $this->generarFibonacci($limiteFibonacci);
            return response()->json([
                'numero' => $numero1,
                'tabla' => $tabla,
                'fibonacci' => $fibonacci
            ], 200);
        }
        if ($numero2 <= 0) {
            $tabla1 = $this->generarTablaMultiplicar($numero1);
            return response()->json([
                'numero1' => $numero1,
                'tabla1' => $tabla1
            ], 200);
        } else if ($numero1 > 0 | $numero2 > 0) {
            $tabla1 = $this->generarTablaMultiplicar($numero1);
            $tabla2 = $this->generarTablaMultiplicar($numero2);
            return response()->json([
                'numero1' => $numero1,
                'tabla1' => $tabla1,
                'numero2' => $numero2,
                'tabla2' => $tabla2,

            ], 200);
        }
    }

    private function generarTablaMultiplicar($numero)
    {
        $tabla = [];
        for ($i = 1; $i <= 10; $i++) {
            $tabla[] = "$numero x $i = " . ($numero * $i);
        }
        return $tabla;
    }
    // Método para generar los números de Fibonacci menores o iguales al límite
    private function generarFibonacci($limite)
    {
        $fibonacci = [0, 1];
        $i = 2;

        // Generamos la secuencia de Fibonacci hasta que el próximo número sea mayor que el límite
        while (true) {
            $siguiente = $fibonacci[$i - 1] + $fibonacci[$i - 2];
            if ($siguiente > $limite) {
                break;
            }
            $fibonacci[] = $siguiente;
            $i++;
        }

        // Filtramos los números de Fibonacci que son menores o iguales al límite
        return array_filter($fibonacci, function ($numero) use ($limite) {
            return $numero <= $limite;
        });
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "nombre" => 'required|string|min:3|max:255',
        ]);
        if ($validate->fails()) {
            return response()->json([
                "msg" => "Error en validacion",
                "error" => $validate->message(),
            ], 422);
        }
        $persona = new Persona();
        $persona->nombre = $request->nombre;
        $persona->save();
        return response()->json([
            "msg" => "Datos almacenados correctamente",
            "data" => $persona,
        ], 422);
    }

    public function insert(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "nombre" => 'required|string|min:3|max:255',
            "edad" => 'required|numeric',
            "apellido_paterno" => 'required|string',
            "apellido_materno" => 'required|string',
            "phone" => 'required|numeric',
            "email" => 'required|email',
          
           
        ]);
        if ($validate->fails()) {
            return response()->json([
                "msg" => "Error en validacion",
                "error" => $validate->message(),
            ], 422);
        }
        $Humano = new Humano();
        $Humano->nombre = $request->nombre;
        $Humano->apellido_paterno = $request->apellido_paterno;
        $Humano->apellido_materno = $request->apellido_materno;
        $Humano->edad = $request->edad;
        $Humano->phone = $request->phone;
        $Humano->email = $request->email;
        
        $Humano->save();
        return response()->json([
            "msg" => "Datos almacenados correctamente",
            "data" => $Humano,
        ], 422);
    }
}
