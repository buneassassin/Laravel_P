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
    
        // Crear la respuesta con la cookie que almacena la palabra original
        return response()->json([
            'palabra' => str_repeat('_', strlen($palabra)), // Ocultar la palabra
            'letras_adivinadas' => [],
            'intentos_restantes' => 6,
            'mensaje' => 'Juego iniciado. ¡Empieza a adivinar!',
        ])->cookie('palabra_original', $palabra, 60); // Almacenar la palabra original en la cookie (60 minutos)
    }
    

    // Adivinar una letra
    public function adivinar(Request $request)
    {
        // Recuperar la palabra original desde la cookie
        $palabra = $request->cookie('palabra_original');
        if (!$palabra) {
            return response()->json([
                'mensaje' => 'No hay juego en progreso. Inicia un nuevo juego.',
            ], 400);
        }
    
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
