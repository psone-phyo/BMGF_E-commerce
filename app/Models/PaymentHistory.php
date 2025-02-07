<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'username',
        'phone',
        'address',
        'payslip_image',
        'payment_type',
        'order_code',
        'total_amt',
];
}
