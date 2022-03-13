<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'article_code', 
        'article_name', 
        'unit_price', 
        'quantity',
        'order_code',
        'order_date',
        'total_amount_without_discount',
        'total_amount_with_discount'
    ];
    

    public function rules() {
        return [
            'article_code' => 'required',
            'article_name' => 'required',
            'unit_price' => 'required',
            'quantity' => 'required'
        ];
    }

    public function feedback() {
        return [
            'required' => 'O campo :attribute é obrigatório'
        ];
    }

    public function customRulesOne() {
        return [
            'OrderCode' => 'required' 
        ];
    }

    public function customRulesTwo() {
        return [
            'id' => 'required' 
        ];
    }

    public function hasDiscount() {
        if ( ($this->quantity >= 5 && $this->quantity <=9) && ($this->totalAmountWithoutDiscount() > 500) ) {
            return true;
        }
        return false;
    }
        
    public function totalAmountWithoutDiscount() {
        return $this->quantity * $this->unit_price;
    }

    public function totalAmountWithDiscount() {
        return $this->totalAmountWithoutDiscount() - ($this->totalAmountWithoutDiscount() * 0.15);
    }

    public function generateTotalPrice(Order $order) {
        $order->total_amount_without_discount = $this->totalAmountWithoutDiscount();
        
        if ($order->hasDiscount()) {
            $order->total_amount_with_discount = $this->totalAmountWithDiscount();
            return $order;
        } 
        return $order;
    }

    public function generateOrderData(Order $order) {
        $order = $this->generateTotalPrice($order);
        $this->generateOrderDate();
        $this->generateOrderCode();
        $this->confirmOrder();

        return $order;
    }

    public function generateOrderDate() {
        $this->order_date = date('Y-m-d', strtotime($this->created_at));
    }

    public function generateOrderCode() {
        $this->order_code = substr($this->order_date, 0, strlen($this->order_date)-2) . $this->order_id;
    }

    public function confirmOrder() {
        $this->update();
    }

}
