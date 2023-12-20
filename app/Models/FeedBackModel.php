<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FeedBackModel extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    public $timestamps = false;

    protected $fillable = [
        'date',
        'user_name',
        'email',
        'phone',
        'code_country',
        'experience',
        'com_design',
        'com_content',
        'com_funtionallity',
        'com_ease_use',
        'com_suggest',
    ];

    protected $casts = [
        'date' => 'date',
        'code_country' => 'integer',
        'experience' => 'string',
    ];
    
}
