<?php

namespace App\Repositories;


class OrderRepository extends AbstractRepository {
    
    public function findAllGroupByArticleCode() {
        return $this->model->all()->groupBy('article_code');
    }

    public function findAllWithGeneratedResponse() {
        $orders = response()->json($this->model->all());

        $data = $orders->getData();

        $generatedResponseObject = [];

        for ($i=0; $i < sizeof($data); $i++) { 
            $this->model = $data[$i];
            $generatedResponseObject[$i] = $this->responseConverter();
        }
       return $generatedResponseObject;
    }

    public function responseConverter() {
        return $generatedResponseObject = [
            'OrderId' => $this->model->order_id,
            'OrderCode' => $this->model->order_code,
            'OrderDate' => $this->model->order_date,
            'TotalAmountWithDiscount' => $this->model->total_amount_with_discount != null ? $this->model->total_amount_with_discount : 'Not qualified for discount',
            'TotalAmountWithoutDiscount' => $this->model->total_amount_without_discount
        ];
    }

}

?>