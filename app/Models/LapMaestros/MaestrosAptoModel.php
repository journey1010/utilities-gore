<?php

namespace App\Models\LapMaestros;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaestrosAptoModel extends Model
{
    use HasFactory;

    public $table = 'maestro_apto_lap';

    protected $connection = 'utilities'; 

    protected $fillable = [
        'full_name',
        'provincia',
        'dni',
        'ie',
        'condicion',
        'nivel',
        'distrito',
        'status',
    ];
}
