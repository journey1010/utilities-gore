<?php

namespace App\Models\LapMaestros;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LapSerieModel extends Model
{
    use HasFactory;

    public $table = 'laptops_data';
    public $timestamps  = false;
    protected $connection = 'utilities';


    protected $fillable = [
        'caja',
        'serie',
        'condicion'
    ];
}
