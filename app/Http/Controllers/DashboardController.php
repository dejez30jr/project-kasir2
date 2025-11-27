<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function redirectByRole()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');
        if ($user->role === 'admin') return redirect()->route('dashboard.admin');
        if ($user->role === 'cashier') return redirect()->route('dashboard.cashier');
        return redirect()->route('dashboard.user');
    }

    public function admin()
    {
        $totalProducts = Product::count();
        $todaySales = Order::whereDate('created_at', today())
            ->whereIn('status', ['paid','completed'])
            ->sum('grand_total');
        $pendingPickups = Order::where('order_type','pickup_later')
            ->where('status','pending')->count();
        $latestOrders = Order::latest()->limit(10)->get(['id','grand_total','payment_status','order_type']);

        // Basic sales data for chart (last 7 days)
        $labels = [];
        $data = [];
        for ($i=6; $i>=0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $labels[] = $date;
            $data[] = (float) Order::whereDate('created_at', $date)
                ->whereIn('status',['paid','completed'])
                ->sum('grand_total');
        }

        return view('dashboard.admin', compact('totalProducts','todaySales','pendingPickups','labels','data','latestOrders'));
    }

    public function cashier()
    {
        $products = Product::orderBy('name')->paginate(12);
        $pending = Order::where('status','pending')->latest()->limit(10)->get();
        return view('dashboard.cashier', compact('products','pending'));
    }

    public function user()
    {
        $products = Product::orderBy('name')->paginate(12);
        $orders = Order::where('user_id', Auth::id())->latest()->limit(10)->get();
        return view('dashboard.user', compact('products','orders'));
    }
}
