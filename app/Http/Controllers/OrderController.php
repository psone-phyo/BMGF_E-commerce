<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function store(Request $request){
    $validator = Validator::make($request->all(), [
        '*.product_id' => 'required',
        '*.count' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'error' => $validator->errors()
        ], 400);
    }

    $ordercode = 'bmgf_'.uniqid();
    foreach ($request->all() as $item) {
        Order::create([
            'user_id' => Auth::user()->id,
            'product_id' => $item['product_id'],
            'count' => $item['count'],
            'order_code' => $ordercode
        ]);
    }

    return response()->json([
        'order_code' => $ordercode
    ], 201);
}
}
