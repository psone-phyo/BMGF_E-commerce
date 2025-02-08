<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentHistoryController extends Controller
{
    //for admin
    public function orderlist(){
        $data = PaymentHistory::select('users.name', 'users.email', 'payment_histories.*', 'orders.count')
            ->leftjoin('users', 'users.id', '=', 'payment_histories.user_id')
            ->leftJoin('orders', 'orders.order_code', '=', 'payment_histories.order_code')
            // ->groupby('payment_histories.order_code')
            ->get();
            dd($data->toArray());
        }

    //for client
    public function checkout(Request $request){
        $validation = Validator::make($request->all(), [
            'phone' => 'required|max:15',
            'address' => 'required|max:255',
            'paymentmethod' => 'required|max:50',
            'payment_id' => 'required|max:50',
            'ordercode' => 'required|max:50',
            'totalamount' => 'required|numeric',
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
            'payment_type' => $request->paymentmethod,
            'payment_id' => $request->payment_id,
            'order_code' => $request->ordercode,
            'total_amt' => $request->totalamount,
    ]);
    }
}
