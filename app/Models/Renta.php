<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renta extends Model
{
    use HasFactory;

    protected $table = 'rentas';

    protected $fillable = [
        'acceso',
        'hours',
        'salida',
        'placa',
        'modelo',
        'marca',
        'color',
        'llaves',
        'total',
        'efectivo',
        'cambio',
        'user_id',
        'vehiculo_id',
        'tarifa_id',
        'barcode',
        'estatus',
        'description',
    ];
}
