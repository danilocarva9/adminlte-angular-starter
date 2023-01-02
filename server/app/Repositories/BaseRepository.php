<?php 
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    abstract public function getModel(): Model;

    // public function findBy(string $attribute, string $value): Model
    // {
    //    return $this->getModel()->where($attribute, '=', $value)->first();
    // }


    public function findBy(array $attributes, string $compareType = '=')
    {
       return $this->findByParams($attributes, $compareType)->first();
    }


    public function updateBy(array $params, int $id): Bool
    {
        return $this->getModel()->findOrFail($id)->updateOrFail($params);
    }
 
    public function create(array $data): Model
    {
        return $this->getModel()->create($data);
    }


     /**
     * Build a query base
     *
     * @param array  $params
     * @param string $defaultCompareType
     * @return Model|Builder
     */
    private function findByParams(array $params, string $defaultCompareType = '=')
    {
        /** @var Builder $query */
        $query = $this->getModel();
        foreach ($params as $param) {
            $compareType = count($param) === 2 ? $defaultCompareType : $param[2];
            if (mb_strtoupper($compareType) === 'IN') {
                $query = $query->whereIn($param[0], $param[1]);
            } else {
                $query = $query->where($param[0], $compareType, $param[1]);
            }
        }
        return $query;
    }

}