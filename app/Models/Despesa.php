<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;

class Despesa extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'descricao',
        'valor',
        'data_criacao',
        'usuario_id'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, "usuario_id");
    }
}
