<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function get(){
        $payments = Payment::all();
        return response()->json([
            'meta' => count($payments),
            'data' => $payments
        ], 200);
    }

    public function store(Request $request){
        $validation = Validator::make($request->all(), [
            'account_number' => 'required',
            'account_type' => 'required|numeric',
            'account_name' => 'required',
        ]);

        if ($validation->fails()) {
            $errors = collect($validation->errors()->toArray())->map(function ($error) {
                return $error[0];
            });
            return response()->json([
                'error' => $errors
            ], 401);
        }

        Payment::create([
            'account_number' => $request->number,
            'account_type' => $request->type,
            'account_name' => $request->name,
        ]);
        return response()->json([
            'success' => "successfully created"
        ],201);
    }

    public function update(Request $request, $id){
        if (!$id){
            return response()->json([
                'error' => "payment id is required"
            ],400);
        }
        $payment = Payment::find($id);
        if (!$payment){
            return response()->json([
                'error' => "payment not found"
            ],400);
        }

        $payment->update([
            'account_number' => $request->number,
            'account_type' => $request->type,
            'account_name' => $request->name,
        ]);
        return response()->json([
            'success' => "successfully updated"
        ],200);
    }

    public function delete($id){
        if (!$id){
            return response()->json([
                'error' => "payment id is required"
            ],400);
        }
        $payment = Payment::find($id);
        if (!$payment){
            return response()->json([
                'error' => "payment not found"
            ],400);
        }

        Payment::find($id)->delete();
        return response()->json([
            'success' => "successfully deleted"
        ],200);;
    }
}
