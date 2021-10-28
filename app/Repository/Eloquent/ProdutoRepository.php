<?php

namespace App\Repository\Eloquent;

use App\Models\Produto;
use App\Repository\ProdutoRepositoryInterface;
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
            'loja_id' => 'exists:App\Models\Loja,id|integer'
            // 'email' => 'unique:lojas|email',
            // 'nome' => 'min:3|max:40'
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
            // 'email' => [Rule::unique('lojas', 'email')->ignore($this->model->id), 'email'],
            // 'nome' => 'min:3|max:40'
        ];
    }
}