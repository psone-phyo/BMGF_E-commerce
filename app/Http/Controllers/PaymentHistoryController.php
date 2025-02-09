<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentHistoryController extends Controller
{
    public function orderlist()
    {
        try{
            $data = PaymentHistory::select('order_code', 'total_amt', 'status')
            ->where('user_id', Auth::user()->id)
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

    //for client
    public function checkout(Request $request)
    {
        try{
            $validation = Validator::make($request->all(), [
                'phone' => 'required|max:15',
                'address' => 'required|max:255',
                'order_code' => 'required|max:50',
                'total_amt' => 'required|numeric',
            ]);

            if ($validation->fails()) {
                $errors = collect($validation->errors()->toArray())->map(function ($error) {
                    return $error[0];
                });
                return response()->json([
                    'error' => $errors
                ], 401);
            }

            PaymentHistory::create([
                'user_id' => Auth::user()->id,
                'phone' => $request->phone,
                'address' => $request->address,
                'order_code' => $request->order_code,
                'total_amt' => $request->total_amt,
            ]);

            return response()->json([
                'success' => 'Order is successfully created'
            ], 201);
        }catch(Exception $e){
            return response()->json([
                'error' => $e
            ], 500);
        }

    }

    public function orderdetails()
    {
        try{
            if (Auth::user()->role == 'admin'){
                $data = Order::select('products.name', 'products.price', 'products.photo', 'products.stock' ,'orders.count')
                ->leftjoin('products', 'orders.product_id', 'products.id')
                ->where('orders.order_code', request('order_code'))
                ->get();
            }else{
                $data = Order::select('products.name', 'products.price', 'products.photo' ,'orders.count')
                ->leftjoin('products', 'orders.product_id', 'products.id')
                ->where('orders.order_code', request('order_code'))
                ->get();
            }
        return response()->json([
            'data' => $data
        ], 200);
        }catch (Exception $e){
            return response()->json([
                'error' => $e
            ],500);
        }

    }
}
