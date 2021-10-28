<?php

namespace App\Repository\Eloquent;

use App\Models\Loja;
use App\Repository\LojaRepositoryInterface;
use Illuminate\Validation\Rule;

class LojaRepository extends BaseRepository implements LojaRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository construct
     * 
     * @param Loja $model
     */
    public function __construct(Loja $model)
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
            'email' => 'unique:lojas|email',
            'nome' => 'min:3|max:40'
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
            'email' => [Rule::unique('lojas', 'email')->ignore($this->model->id), 'email'],
            'nome' => 'min:3|max:40'
        ];
    }
}