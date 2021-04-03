<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface IRepository
{
    /**
     * @param int id d
     * @return Model|null
     */
    public function find(int $id): Model;
    
    /**
     * @return Model[]|Collection
     */
    public function findAll(): Collection;
    
    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model;
    
    /**
     * @param array $data
     * @param int $id
     * @return Model
     */
    public function update(array $data,int $id);

}