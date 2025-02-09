<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\PaymentHistory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function get(){
        $userCount = User::count();
        $productCount = Product::count();
        $orderCount = PaymentHistory::count();
        $categoryCount = Category::count();

        return response()->json([
            ['title' => 'Users', 'count' => $userCount],
            ['title' => 'Products', 'count' => $productCount],
            ['title' => 'Orders', 'count' => $orderCount],
            ['title' => 'Categories', 'count' => $categoryCount],
        ],200);
    }
}
