<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable  = [
        'nome', 'valor', 'loja_id', 'ativo'
    ];
    
    protected $hidden = ['deleted_at'];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s'
    ];

    public function loja()
    {
        return $this->belongsTo(Loja::class);
    }

    /**
     * get valor formated.
     * TODO implementing mutate with repository and money formmater
     * 
     * @param  string  $value
     * @return string
     */
    public function getValorAttribute($value)
    {
        return "R$ ".number_format($value,'2',',','.');
    }
}
