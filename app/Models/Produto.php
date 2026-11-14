<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Attributes\Fillable;

use App\Models\Scopes\ProdutoRelationsScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Znck\Eloquent\Relations\BelongsToThrough;

// #[Fillable(['nome', 'descricao', 'qtd_estoque', 'preco', 'importado'])]
#[ScopedBy([ProdutoRelationsScope::class])]
class Produto extends Model
{
    /** @use HasFactory<\Database\Factories\ProdutoFactory> */
    use HasFactory,  \Znck\Eloquent\Traits\BelongsToThrough;

    // protected $table = 'produtos';

    protected $fillable = [
        'nome',
        'descricao',
        'qtd_estoque',
        'preco',
        'importado',
        'fornecedor_id'
    ];

    //  protected static function booted(): void
    // {
    //     static::addGlobalScope(new ProdutoRelationsScope);
    // }

    public function fornecedor():BelongsTo
    {
        // return $this->belongsTo(
        //         Fornecedor::class,
        //         'fornecedor_id',
        //         'id_fornecedor'
        //     );
        return $this->belongsTo(Fornecedor::class);
    }

    public function regiao():BelongsToThrough
    {
        return $this->belongsToThrough(
            Regiao::class,
            [
                Estado::class,
                Fornecedor::class
            ],
            foreignKeyLookup: [
                Regiao::class => 'regiao_id',
                Fornecedor::class => 'fornecedor_id'
            ]
        );
    }


    public function promocoes():BelongsToMany
    {
        return $this->belongsToMany(Promocao::class)
            ->withPivot('desconto')
            ->withTimestamps();
    }

    public function medias(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

     //query scope Local
    public function scopePorRegiao(Builder $query, string $nome)
    {
        // return  $query->whereHas('fornecedor',fn($q) => $q->whereHas('estado',fn($q) => $q->whereHas('regiao',fn($q) => $q->where('nome', 'like', $nome))));
        // return $query->whereHas(
        //     'fornecedor',
        //     fn($q) => $q->whereHas(
        //         'estado',
        //         fn($q) => $q->whereHas(
        //             'regiao',
        //             fn($q) => $q->where('nome', 'like', $nome)
        //         )
        //     )
        // );
        // return Regiao::where('nome', $nome)->with('produtos');
        return $query->whereHas('regiao',fn($q)=>$q->where('regioes.nome','like',"%$nome%"));
    }

     //https://laravel.com/docs/master/eloquent#query-scopes
    public function scopeImportados(Builder $query, bool $importado = true)
    {
        return $query->where('importado', $importado);
    }
}
