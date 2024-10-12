<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AhorcadoController extends Controller
{
    public function jugar(Request $request, $indicePalabra, $jugar)
    {
        $palabras = ['php', 'framework', 'laravel', 'insomnia', 'code', 'javascript', 'python', 'java'];
        $indicePalabra = intval($indicePalabra); // Convertir el índice de palabra a un número entero
        $palabra = $palabras[$indicePalabra] ?? null; // Obtener la palabra según el índice

        if (!$palabra) {
            return response()->json([
                'mensaje' => 'Índice de palabra inválido.',
            ], 400);
        }

        $intentos = 4; // Número de intentos permitidos
        $letras_adivinadas = $request->input('letras_adivinadas', []); // Obtener letras ya adivinadas del cuerpo del request
        $letras = $request->input('letras', []); // Obtener las letras que se adivinaron en esta jugada

        // Verificar si el juego ha comenzado
        if (!$jugar) {
            return response()->json([
                'mensaje' => "¡Juego no iniciado, inicia el juego para comenzar a adivinar!",
                'palabra' => str_repeat('_', strlen($palabra)) . " (" . strlen($palabra) . " letras)"
            ]);
        }

        // Procesar las letras adivinadas
        $mensaje = '';
        foreach ($letras as $letra) {
            $letra = strtolower($letra); // Asegurarse de que la letra esté en minúsculas

            if (!in_array($letra, $letras_adivinadas)) {
                $letras_adivinadas[] = $letra;

                // Verificar si la letra está en la palabra
                if (strpos($palabra, $letra) !== false) {
                    $mensaje = "¡Correcto!";
                } else {
                    $mensaje = "¡Incorrecto!";
                    $intentos--; // Reducir intentos si la letra no está en la palabra
                }
            } else {
                $mensaje = "¡Ya adivinaste esa letra!";
                $intentos--;
            }
        }

        // Verificar si el jugador ha perdido
        if ($intentos <= 0) {
            return response()->json([
                'mensaje' => "¡Juego terminado, se acabaron los intentos! La palabra era: " . $palabra
            ]);
        }

        // Mostrar la palabra oculta con las letras adivinadas
        $palabraOculta = implode('', array_map(function ($letra) use ($letras_adivinadas) {
            return in_array($letra, $letras_adivinadas) ? $letra : '_';
        }, str_split($palabra)));

        // Verificar si el jugador ha ganado
        if (strpos($palabraOculta, '_') === false) {
            return response()->json([
                'mensaje' => "¡Ganaste! La palabra era: " . $palabra . ". ¡Enhorabuena!"
            ]);
        }

        return response()->json([
            'mensaje' => "¡Sigue intentando! " . $mensaje,
            'palabra' => $palabraOculta,
            'intentos_restantes' => $intentos
        ]);
    }
}
