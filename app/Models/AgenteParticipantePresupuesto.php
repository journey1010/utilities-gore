<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgenteParticipantePresupuesto extends Model
{
    use HasFactory;

    protected $table = 'agentes_participantes_presupuesto';

    protected $fillable = [
        'full_name',
        'dni',
        'fecha_nacimiento',
        'genero',
        'organizacion',
        'organizacion_tipo',
        'email',
        'profesion',
        'cargo',
        'comite_vigilancia',
        'equipo_tecnico',
        'grado_instruccion',
        'credencial',
        'path_file',
        'created_at'
    ];

    public static function saveAgente(
        $fullName,
        $dni,
        $fechaNacimiento,
        $genero,
        $organizacion,
        $organizacionTipo,
        $email,
        $profesion,
        $cargo,
        $comiteVigilancia,
        $equipoTecnico,
        $gradoInstruccion,
        $pathFile
    ) {
        AgenteParticipantePresupuesto::create([
            'full_name' => $fullName,
            'dni' =>  $dni,
            'fecha_nacimiento' => $fechaNacimiento,
            'genero' => $genero,
            'organizacion' => $organizacion,
            'organizacion_tipo' => $organizacionTipo,
            'email' => $email,
            'profesion' => $profesion,
            'cargo' => $cargo,
            'comite_vigilancia' => $comiteVigilancia,
            'equipo_tecnico'  =>   $equipoTecnico,
            'grado_instruccion' => $gradoInstruccion,
            'credencial' =>$pathFile,
            'created_at' => date('Y-m-d H:i:s') 
        ]);
        return;
    }
}
