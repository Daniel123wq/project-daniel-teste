<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loja extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable  = [
        'nome', 'email'
    ];
    
    protected $hidden = ['deleted_at'];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i:s',
        'updated_at' => 'datetime:d/m/Y H:i:s'
    ];

    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }
}
