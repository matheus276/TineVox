<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Condominio extends Model
{
    protected $table = 'condominios';
    protected $primaryKey = 'id_condominio';
    public $timestamps = false;

    protected $fillable = [
        'nome',
        'cnpj',
        'endereco',
        'telefone',
        'email',
        'pasta_gravacoes',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'usuarios_condominios', 'id_condominio', 'id_usuario')
            ->withPivot('data_cadastro');
    }
}
