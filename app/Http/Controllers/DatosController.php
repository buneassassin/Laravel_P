<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dueño;
use App\Models\Mascota;
use App\Models\Raza;
use App\Models\Vacuna;
use App\Models\HistorialMedico;
use App\Models\VisitaVeterinaria;
use App\Models\Veterinario;
use App\Models\Consulta;
use App\Models\ClinicaVeterinaria;
use App\Models\Cita;

class DatosController extends Controller
{
    public function mostrarDetallesMascota($id)
    {
        
        // Buscar la mascota por ID, incluyendo todas las relaciones necesarias
        $mascota = Mascota::with([
            'dueño', 
            'raza', 
            'historialMedico', 
            'visitasVeterinarias.veterinario', 
            'visitasVeterinarias.veterinario.consultas',
            'visitasVeterinarias.veterinario.consultas.clinica'
        ])->find($id);
    
        // Si no se encuentra la mascota
        if (!$mascota) {
            return response()->json(['mensaje' => 'Mascota no encontrada'], 404);
        }
    
        // Retornar la información de la mascota con todas las tablas relacionadas
        return response()->json($mascota, 200);
    }
    // Insertar Dueño
    public function insertarDueño(Request $request)
    {
        $dueño =new Dueño();
        $dueño->nombre = $request->nombre;
        $dueño->email= $request->email;
        $dueño->teléfono = $request->teléfono;
        $dueño->save();
        return response()->json($dueño, 201);
    }

    // Insertar Mascota
    public function insertarMascota(Request $request)
    {
        $mascota=new Mascota();
        $mascota->nombre = $request->nombre;
        $mascota->dueño_id = $request->dueño_id;
        $mascota->raza_id = $request->raza_id;
        $mascota->vacuna_id = $request->vacuna_id;
        $mascota->fecha_nacimiento = $request->fecha_nacimiento;
        $mascota->save();
        return response()->json($mascota, 201);
    }

    // Insertar Raza
    public function insertarRaza(Request $request)
    {
        $raza=new Raza();
        $raza->nombre = $request->nombre;
        $raza->save();
        return response()->json($raza, 201);
    }

    // Insertar Vacuna
    public function insertarVacuna(Request $request)
    {
        $vacuna=new Vacuna();
        $vacuna->nombre = $request->nombre;
        $vacuna->descripción= $request->descripción;
        $vacuna->save();
        return response()->json($vacuna, 201);
    }

    // Insertar Historial Médico
    public function insertarHistorialMedico(Request $request)
    {
        $historial=new HistorialMedico();
        $historial->mascota_id = $request->mascota_id;
        $historial->notas = $request->notas;
        $historial->save();
        return response()->json($historial, 201);
    }

    // Insertar Visita Veterinaria
    public function insertarVisitaVeterinaria(Request $request)
    {
        $visita=new VisitaVeterinaria();
        $visita->mascota_id = $request->mascota_id;
        $visita->fecha_visita = $request->fecha_visita;
        $visita->motivo = $request->motivo;
        $visita->save();
        return response()->json($visita, 201);
    }

    // Insertar Veterinario
    public function insertarVeterinario(Request $request)
    {
        $veterinario=new Veterinario();
        $veterinario->nombre = $request->nombre;
        $veterinario->especialización = $request->especialización;
        $veterinario->save();
        return response()->json($veterinario, 201);
    }

    // Insertar Consulta
    public function insertarConsulta(Request $request)
    {
        $consulta=new Consulta();
        $consulta->mascota_id = $request->mascota_id;
        $consulta->veterinario_id = $request->veterinario_id;
        $consulta->diagnóstico = $request->diagnóstico;
        $consulta->tratamiento = $request->tratamiento;
        $consulta->save();
        return response()->json($consulta, 201);
    }

    // Insertar Clínica Veterinaria
    public function insertarClinicaVeterinaria(Request $request)
    {
        $clinica=new ClinicaVeterinaria();
        $clinica->nombre = $request->nombre;
        $clinica->dirección = $request->dirección;
        $clinica->teléfono = $request->teléfono;
        $clinica->save();
        return response()->json($clinica, 201);
    }

    // Insertar Cita
    public function insertarCita(Request $request)
    {
        $cita=new Cita();
        $cita->mascota_id = $request->mascota_id;
        $cita->clínica_id = $request->clínica_id;
        $cita->veterinario_id = $request->veterinario_id;
        $cita->fecha_cita = $request->fecha_cita;
        $cita->save();
        return response()->json($cita, 201);
    }
}
