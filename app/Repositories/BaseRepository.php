<?php
namespace App\Repositories;

use App\Repositories\IRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements IRepository
{
    abstract function getModel(): Model;

      /**
     * @param int id d
     * @return Model|null
     */
    public function find(int $id): Model
    {
        return $this->getModel()->find($id);
    }

     /**
     * @return Model[]|Collection
     */
    public function findAll(): Collection
    {
        return $this->getModel()->all();
    }

     /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->getModel()->create($data);
    }

     /**
     * @param array $data
     * @param int $id
     * @return Model
     */
    public function update(array $data, int $id): Model
    {
        $record = $this->getModel->find($id);
        return $record->update($data);
    }
}
