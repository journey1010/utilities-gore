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
        'id_form',
        'credencial',
        'created_at'
    ];

    public static function saveAgente(
        $fullName,
        $dni,
        $fechaNacimiento= null,
        $genero= null,
        $organizacion,
        $organizacionTipo= null,
        $email= null,
        $profesion= null,
        $cargo,
        $comiteVigilancia= null,
        $equipoTecnico= null,
        $gradoInstruccion= null,
        $idForm,
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
            'id_form' => $idForm,
            'credencial' =>$pathFile,
            'created_at' => date('Y-m-d H:i:s') 
        ]);
        return;
    }

    public static function list(int $itemsPerPage, int $page)
    {
        $list = AgenteParticipantePresupuesto::select()
            ->paginate($itemsPerPage, ['*'], 'page', $page);

        $response = [
            'data' => $list->items(),
            'total_items' => $list->total(),
        ];
        return $response;
    }
}