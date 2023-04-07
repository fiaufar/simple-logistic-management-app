<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Find resource.
     * 
     * @param mixed $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find($id)
    {
        return $this->model->find($id);   
    }

    /**
     * Create new resource.
     * 
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        // Add created_by info
        $data['created_by'] = auth()->user()->id;

        return $this->model->create($data);
    }

    /**
     * Update existing resource.
     * 
     * @param mixed $id
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($id, array $data)
    {
        // Update the updated_by info
        $data['updated_by'] = auth()->user()->id;

        return $this->model->where('id', $id)->update($data);
    }

    /**
     * Delete existing resource.
     * 
     * @param mixed $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->model->delete($id)
                ? true : false;
    } 
}