<?php 
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    abstract public function getModel(): Model;

    public function findBy(string $attribute, string $value): Model
    {
       return $this->getModel()->where($attribute, '=', $value)->first();
    }

    public function updateBy(array $params, int $id): Bool
    {
        return $this->user->findOrFail($id)->updateOrFail($params);
    }
 
    public function create(array $data): Model
    {
        return $this->getModel()->create($data);
    }

}