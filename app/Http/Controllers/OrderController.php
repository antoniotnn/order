<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Repositories\OrderRepository;

class OrderController extends Controller
{
    
    public function __construct(Order $order) {
        $this->order = $order;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orderRepository = new OrderRepository($this->order);

        return response()->json($orderRepository->findAllWithGeneratedResponse(), 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ordersAgregated(Request $request)
    {
        $orderRepository = new OrderRepository($this->order);

        return response()->json($orderRepository->findAllGroupByArticleCode(), 200);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->order->rules(), $this->order->feedback());

        $this->order->article_code = $request->get('article_code');
        $this->order->article_name = $request->get('article_name');
        $this->order->unit_price = $request->get('unit_price');
        $this->order->quantity = $request->get('quantity');
        
        $orderRepository = new OrderRepository($this->order);
        $orderRepository->saveModel();

        $this->order = $this->order->generateOrderData($this->order);

        return response()->json($orderRepository->responseConverter(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orderRepository = new OrderRepository($this->order);

        $order = $orderRepository->findById($id);

        if ($order === null) {
            $primaryKeyColumn = $this->order->getKeyName();
        
            return response()->json(['error' => "$primaryKeyColumn $id not Found"], 404);
        }
        return response()->json($order, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $orderRepository = new OrderRepository($this->order);
        $order = $orderRepository->findById($id);

        if($order === null) {
            return response()->json(['error' => 'Impossible to update. Resource not found.'], 404);
        }
        if ($request->method() === 'PATCH') {
            $dynamicRules = array();

            foreach ($order->rules() as $input => $rule) {
                if (array_key_exists($input, $request->all())) {
                    $dynamicRules[$input] = $rule;
                }
            }
            $request->validate($dynamicRules, $order->feedback());
        } else {
            $request->validate($order->rules(), $order->feedback());
        }
        return response()->json($orderRepository->saveModel($order), 200);

        $orderRepository->saveModel();
        return response()->json($orderRepository->responseConverter(), 200);
    }

    public function customInputUpdateDefault(Request $request)
    {
        $urlCustom = $request->url();
        $validator = null;

        if ($urlCustom === 'http://localhost/api/orders/update-custom') {
            $id = $request->get('OrderId');
            $validator = 1;
        } else {
            $id = $request->get('id');
            $validator = 2;
        }
        $orderRepository = new OrderRepository($this->order);
        
        $order = $orderRepository->findById($id);

        if($order === null) {
            return response()->json(['error' => 'Impossible to update. Resource not found.'], 404);
        }
        if ($request->method() === 'PATCH') {
            $dynamicRules = array();
            
            foreach (($validator === 1 ? $order->customRulesOne() : $order->customRulesTwo()) as $input => $rule) {
                if (array_key_exists($input, $request->all())) {
                    $dynamicRules[$input] = $rule;
                }
            }
            $request->validate($dynamicRules, $order->feedback());
        } else {
            $request->validate(($validator === 1 ? $order->customRulesOne() : $order->customRulesTwo()), $order->feedback());
        }

        if ($urlCustom === 'http://localhost/api/orders/update-custom') {
            $order->order_code = $request->get('OrderCode');
            $order->order_date = $request->get('OrderDate');
            $order->total_amount_without_discount = $request->get('TotalAmountWithoutDiscount');
    
            if ($request->has('TotalAmountWithDiscount')) {
                $order->total_amount_with_discount = $request->get('TotalAmountWithDiscount');
            }
        } else {
            $order->order_code = $request->get('code');
            $order->order_date = $request->get('date');
        }

        if ($urlCustom === 'http://localhost/api/orders/update-custom2') {
            $order->total_amount_without_discount = $request->get('total');
            if ($request->has('discount')) {
                $order->total_amount_with_discount = $request->get('discount');
            }
        } else {
            $order->total_amount_without_discount = $request->get('totalAmount');
            if ($request->has('totalAmountWithDiscount')) {
                $order->total_amount_with_discount = $request->get('totalAmountWithDiscount');
            }
        }

        $orderRepository->saveModel();

        return response()->json($orderRepository->responseConverter(), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
