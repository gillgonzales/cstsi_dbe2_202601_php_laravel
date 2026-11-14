<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[Table('fornecedores')]
#[Fillable([
    "nome",
    "cnpj",
    "email",
    "estado_id",
    "telefone",
    "endereco"
])]
class Fornecedor extends Model
{
    use HasFactory;

    // protected $primaryKey = 'id_fornecedor';

    public function estado(): BelongsTo
    {
        return $this->belongsTo(Estado::class);
    }

    public function produtos():HasMany
    {
        // return $this->hasMany(Produto::class,'fornecedor_id');//$modelName_$primaKey
        return $this->hasMany(Produto::class);//$modelName_$primaKey
    }

    public function medias(): MorphMany
    {
        return $this->morphMany(Media::class,'mediable');
    }
}
