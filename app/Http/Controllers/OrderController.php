<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
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

    //for admin
    public function orderlist()
    {
        try{
            $data = PaymentHistory::select('order_code', 'total_amt', 'status')
            ->get();
        return response()->json([
            'data' => $data
        ], 200);
        }catch (Exception $e){
            return response()->json([
                'error' => $e
            ],500);
        }

    }

    public function confirm()
    {
        try {
            $data = PaymentHistory::where('order_code', request('order_code'))->first();

            if ($data) {
                $data->update([
                    'status' => 'success'
                ]);

                return response()->json([
                    'success' => "Updated Successfully"
                ], 200);
            } else {
                return response()->json([
                    'error' => "Order code not found"
                ], 422);
            }

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }

    }

    public function reject()
    {
        try {
            $data = PaymentHistory::where('order_code', request('order_code'))->first();

            if ($data) {
                $data->update([
                    'status' => 'rejected'
                ]);

                return response()->json([
                    'success' => "Updated Successfully"
                ], 200);
            } else {
                return response()->json([
                    'error' => "Order code not found"
                ], 422);
            }

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }

    }

}
