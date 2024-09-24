<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AhorcadoController extends Controller
{
    // Array de palabras disponibles
    protected $palabras = ['laravel', 'insomnia', 'php', 'framework'];

    // Adivinar una letra
    public function adivinar(Request $request, $numero)
    {
        // Validar el JSON enviado en el cuerpo de la petición
        $data = $request->validate([
            'letras_adivinadas' => 'array', // Las letras que ya se adivinaron
            'letras_adivinadas.*' => 'string',
            'intentos_restantes' => 'integer', // Los intentos restantes
            'letra' => 'required|string|size:1' // La letra que se intenta adivinar
        ]);

        // Verificar si el número es válido para obtener una palabra
        if (!isset($this->palabras[$numero])) {
            return response()->json([
                'mensaje' => 'Número inválido, no hay palabra asociada.',
            ], 400);
        }

        // Obtener la palabra basada en el número
        $palabra = $this->palabras[$numero];
        $letras_adivinadas = $data['letras_adivinadas'] ?? [];
        $intentos_restantes = $data['intentos_restantes'] ?? 6;
        $letra = strtolower($data['letra']); // La letra enviada en el JSON

        // Verificar si la letra ya fue adivinada
        if (in_array($letra, $letras_adivinadas)) {
            return response()->json([
                'mensaje' => 'Letra ya adivinada',
                'estado' => 'repetida',
                'letras_adivinadas' => $letras_adivinadas,
            ]);
        }

        // Agregar la letra a las letras adivinadas
        $letras_adivinadas[] = $letra;

        // Verificar si la letra está en la palabra
        if (strpos($palabra, $letra) !== false) {
            // Mostrar la palabra oculta con las letras adivinadas
            $palabra_oculta = $this->mostrarPalabraOculta($palabra, $letras_adivinadas);

            // Verificar si el jugador ha ganado
            if ($palabra_oculta === $palabra) {
                return response()->json([
                    'mensaje' => '¡Felicidades! Has ganado.',
                    'palabra' => $palabra,
                ]);
            }

            return response()->json([
                'mensaje' => 'Letra correcta',
                'palabra_oculta' => $palabra_oculta,
                'letras_adivinadas' => $letras_adivinadas,
                'intentos_restantes' => $intentos_restantes,
            ]);
        } else {
            // Reducir los intentos si la letra es incorrecta
            $intentos_restantes--;
            if ($intentos_restantes <= 0) {
                return response()->json([
                    'mensaje' => 'Has perdido',
                    'palabra' => $palabra,
                ]);
            }

            return response()->json([
                'mensaje' => 'Letra incorrecta',
                'palabra_oculta' => $this->mostrarPalabraOculta($palabra, $letras_adivinadas),
                'letras_adivinadas' => $letras_adivinadas,
                'intentos_restantes' => $intentos_restantes,
            ]);
        }
    }

    // Función para mostrar la palabra oculta con las letras adivinadas
    private function mostrarPalabraOculta($palabra, $letras_adivinadas)
    {
        $oculta = '';
        foreach (str_split($palabra) as $letra) {
            $oculta .= in_array($letra, $letras_adivinadas) ? $letra : '_';
        }
        return $oculta;
    }
}
