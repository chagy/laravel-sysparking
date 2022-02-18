<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cajas extends Model
{
    use HasFactory;

    protected $table = "cajas";

    protected $fillable = [
        'monto',
        'tipo',
        'concepto',
        'comprobante',
        'user_id'
    ];
}
