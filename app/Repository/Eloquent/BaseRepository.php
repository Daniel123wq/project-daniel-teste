<?php

namespace App\Repository\Eloquent;

use App\Repository\EloquentRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class BaseRepository implements EloquentRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository construct
     * 
     * @param Model $model
     */
    public function __construct(Model $model)
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
        return [];
    }

    /**
     * Get rules for validation model in update
     * 
     * @return array $rules
     */
    public function getRulesUpdate(): array
    {
        return [];
    }

    /**
     * Get All Models
     * 
     * @param array $columns
     * @param array $relations
     * @param int $perPage
     * @param bool $hasPagination
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = [], int $perPage = 25, bool $hasPagination = false): Collection
    {
        if ($relations){
            $columns = array_merge($columns, ['id']);
        }
        $query = $this->model->with($relations);
        if ($hasPagination) {
            return new Collection($query->paginate($perPage, $columns));
        }
        return $query->get($columns);
    }

    /**
     * Get all trashed models
     * 
     * @return Collection
     */
    public function allTrashed(): Collection
    {
        return $this->model->onlyTrashed()->get();
    }

    /**
     * Find Model by id
     * 
     * @param int $modelId
     * @param array $columns
     * @param array $relations
     * @param array $appends
     * @return Model $model
     */
    public function findById(
        int $modelId,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ?Model
    {
        try {
            if ($relations){
                $columns = array_merge($columns, ['id']);
            }
            $this->model = $this->model->select($columns)->with($relations)->findOrFail($modelId)->append($appends);
        } catch (\Throwable $th) {
            throw new Exception('Nenhum objeto encontrado.', 404);
        }
        return $this->model;
    }

    /**
     * Find trashed model by id
     * 
     * @param int $modelId
     * @return Model
     */
    public function findTrashedById(int $modelId): ?Model
    {
        return $this->model->withTrashed()->findOrFail($modelId);
    }

    /**
     * Find only trashed model by id
     * 
     * @param int $modelId
     * @return Model
     */
    public function findOnlyTrashedById(int $modelId): ?Model
    {
        return $this->model->onlyTrashed()->findOrFail($modelId);
    }

    /**
     * Create a model
     * 
     * @param array $payload
     * @return Model
     */
    public function create(Array $payload): ?Model
    {
        $validator = Validator::make($payload, $this->getRulesCreate());
        if ($validator->fails()) {
            $erros = json_encode($validator->errors()->getMessages());
            throw new Exception($erros, 400);
        }
        $model = $this->model->create($payload);
        return $model->fresh();
    }

    /**
     * Update existing model.
     * 
     * @param int $modelId
     * @param array $payload
     * @return bool
     */
    public function update(int $modelId, array $payload): bool
    {
        $this->model = $this->findById($modelId);
        $validator = Validator::make($payload, $this->getRulesUpdate());
        if ($validator->fails()) {
            $erros = json_encode($validator->errors()->getMessages());
            throw new Exception($erros, 400);
        }
        return $this->model->update($payload);
    }
    
    /**
     * Delete model by id
     * 
     * @param int $modelId
     * @return bool $bool
     */
    public function deleteById(int $modelId): bool
    {
        return $this->findById($modelId)->delete();
    }

    /**
     * Restore model by id
     * 
     * @param int $modelId
     * @return bool
     */
    public function restoreById(int $modelId): bool
    {
        return $this->findOnlyTrashedById($modelId)->restore();
    }

    /**
     * Permanently delete model by id
     * 
     * @param int $modelId
     * @return bool
     */
    public function permanentlyDeleteById(int $modelId): bool
    {
        return $this->findTrashedById($modelId)->forceDelete();
    }
}