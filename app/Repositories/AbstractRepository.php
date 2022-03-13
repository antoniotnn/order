<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

abstract class AbstractRepository {

    public function __construct(Model $model) {
        $this->model = $model;
    }

    public function findAll() {
        return $this->model->all();
    }

    public function saveModel() {
        $savingModel =  $this->model->save();
        
        return $savingModel;
    }

    public function findById($modelId) {
        $primaryKeyColumn = $this->model->getKeyName();

        $className = (get_class($this->model));

        $this->model = $className::where($primaryKeyColumn, $modelId)->first();

        return $this->model;
    }

}

?>