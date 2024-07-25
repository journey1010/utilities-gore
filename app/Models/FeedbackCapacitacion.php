<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackCapacitacion extends Model
{
    use HasFactory;

    protected $table = 'feedback_capacitacion';

    protected $timestamps = false;

    protected $fillable = [
        'grado_satisfacción',
        'curso_maxima_atencion',
        'curso_gustaria_aprender',
        'opinion_mejora_capacitacion',
        'horario_capacitacion'
    ];
}