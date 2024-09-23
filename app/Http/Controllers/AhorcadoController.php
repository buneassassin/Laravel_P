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

        // Crear la respuesta con las cookies que almacenan la palabra original, las letras adivinadas y los intentos restantes
        return response()->json([
            'palabra' => str_repeat('_', strlen($palabra)), // Ocultar la palabra
            'letras_adivinadas' => [],
            'intentos_restantes' => 6,
            'mensaje' => 'Juego iniciado. ¡Empieza a adivinar!',
        ])
            ->cookie('palabra_original', $palabra, 60)          // Almacenar la palabra original (60 minutos)
            ->cookie('letras_adivinadas', json_encode([]), 60)   // Inicialmente, letras adivinadas está vacío
            ->cookie('intentos_restantes', 6, 60);               // Intentos iniciales
    }



    // Adivinar una letra
    public function adivinar(Request $request, $letra)
    {
        // Recuperar la palabra original, letras adivinadas y los intentos restantes desde las cookies
        $palabra = $request->cookie('palabra_original');
        $letras_adivinadas = json_decode($request->cookie('letras_adivinadas', '[]'), true);
        $intentos_restantes = $request->cookie('intentos_restantes', 6);

        // Verificar si no hay un juego en progreso
        if (!$palabra) {
            return response()->json([
                'mensaje' => 'No hay juego en progreso. Inicia un nuevo juego.',
            ], 400);
        }

        // Procesar la letra adivinada
        $letra = strtolower($letra);

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
                ])->withoutCookie('palabra_original')
                    ->withoutCookie('letras_adivinadas')
                    ->withoutCookie('intentos_restantes');
            }

            return response()->json([
                'mensaje' => 'Letra correcta',
                'palabra_oculta' => $palabra_oculta,
                'letras_adivinadas' => $letras_adivinadas,
                'intentos_restantes' => $intentos_restantes,
            ])->cookie('letras_adivinadas', json_encode($letras_adivinadas), 60);
        } else {
            // Reducir los intentos si la letra es incorrecta
            $intentos_restantes--;
            if ($intentos_restantes <= 0) {
                return response()->json([
                    'mensaje' => 'Has perdido',
                    'palabra' => $palabra,
                ])->withoutCookie('palabra_original')
                    ->withoutCookie('letras_adivinadas')
                    ->withoutCookie('intentos_restantes');
            }

            return response()->json([
                'mensaje' => 'Letra incorrecta',
                'palabra_oculta' => $this->mostrarPalabraOculta($palabra, $letras_adivinadas),
                'letras_adivinadas' => $letras_adivinadas,
                'intentos_restantes' => $intentos_restantes,
            ])->cookie('letras_adivinadas', json_encode($letras_adivinadas), 60)
                ->cookie('intentos_restantes', $intentos_restantes, 60);
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
