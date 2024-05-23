<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Config\Departamento;
use App\Models\Config\TipoIdentificacion;

class Empleado extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'last_name',
        'departamento_id',
        'tipo_identificacion_id',
        'identificacion',
    ];

    /**
     * Get the departamento associated with the empleado.
     */
    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    /**
     * Get the tipoIdentificacion associated with the empleado.
     */
    public function tipoIdentificacion()
    {
        return $this->belongsTo(TipoIdentificacion::class);
    }
}
