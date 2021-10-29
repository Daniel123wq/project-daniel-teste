<?php

namespace App\Repository\Eloquent;

use App\Mail\SendMailAfterCreateProd;
use App\Models\Produto;
use App\Repository\ProdutoRepositoryInterface;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class ProdutoRepository extends BaseRepository implements ProdutoRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository construct
     * 
     * @param Produto $model
     */
    public function __construct(Produto $model)
    {
        $this->model = $model;
    }

    
    /**
     * Get rules for validation model in create
     * 
     * @return array $rules
     */
    public function getRulesCreate(): array
    {
        return [
            'nome' => 'min:3|max:60',
            'valor' => 'min:3|max:6|integer',
            'loja_id' => 'exists:App\Models\Loja,id|integer',
            'ativo' => 'boolean',
        ];
    }
    /**
     * Get rules for validation model in Update
     * 
     * @return array $rules
     */
    public function getRulesUpdate(): array
    {
        return [
            'nome' => 'min:3|max:60',
            'valor' => 'digits_between:2,6|integer',
            'loja_id' => 'exists:App\Models\Loja,id|integer',
            'ativo' => 'boolean',
        ];
    }

    /**
     * Get the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function getValorAttribute($value)
    {
        return number_format($value,'2','.',',');
    }

    public function updated(): void
    {
        $email = $this->model->loja->email;
        if ($email) {
            Mail::to($email)->send(new SendMailAfterCreateProd($email, 'Atualizado'));
        }
    }
    public function created(): void
    {
        $email = $this->model->loja->email;
        if ($email) {
            Mail::to($email)->send(new SendMailAfterCreateProd($email, 'Criado'));
        }
    }

}