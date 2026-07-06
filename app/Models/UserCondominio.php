<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCondominio extends Model
{
    protected $table = 'usuarios_condominios';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_condominio',
    ];

    protected $casts = [
        'administrador' => 'boolean',
        'data_cadastro' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'idUser');
    }

    public function condominio()
    {
        return $this->belongsTo(Condominio::class, 'id_condominio', 'id_condominio');
    }
}
