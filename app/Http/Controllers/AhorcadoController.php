<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AhorcadoController extends Controller
{
    // Iniciar un nuevo juego
    public function iniciarJuego()
    {
        $palabras = ['laravel', 'insomnia', 'php', 'framework']; // Palabras posibles
        $palabra = $palabras[array_rand($palabras)]; // Seleccionar una palabra aleatoria

        // Generar la respuesta inicial del juego con 6 intentos
        return response()->json([
            'palabra' => str_repeat('_', strlen($palabra)), // Ocultar la palabra
            'letras_adivinadas' => [],
            'intentos_restantes' => 6,
            'mensaje' => 'Juego iniciado. ¡Empieza a adivinar!',
            'palabra_original' => $palabra // Mandar la palabra original para manejar el juego en el cliente
        ]);
    }

    // Adivinar una letra
    public function adivinar(Request $request)
    {
        // Obtener la palabra original, las letras adivinadas, y los intentos restantes del cliente
        $palabra = $request->input('palabra_original');
        $letra = strtolower($request->input('letra'));
        $letras_adivinadas = $request->input('letras_adivinadas', []);
        $intentos_restantes = $request->input('intentos_restantes');

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

            // Continuar si la letra es correcta
            return response()->json([
                'mensaje' => 'Letra correcta',
                'palabra_oculta' => $palabra_oculta,
                'letras_adivinadas' => $letras_adivinadas,
                'intentos_restantes' => $intentos_restantes,
                'palabra_original' => $palabra
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

            // Continuar si la letra es incorrecta
            return response()->json([
                'mensaje' => 'Letra incorrecta',
                'palabra_oculta' => $this->mostrarPalabraOculta($palabra, $letras_adivinadas),
                'letras_adivinadas' => $letras_adivinadas,
                'intentos_restantes' => $intentos_restantes,
                'palabra_original' => $palabra
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
