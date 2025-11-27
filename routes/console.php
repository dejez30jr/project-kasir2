<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Order;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('orders:expire', function () {
    $count = Order::where('order_type','pickup_later')
        ->where('payment_status','unpaid')
        ->where('status','pending')
        ->where('pickup_at','<', now())
        ->update(['status' => 'expired']);
    $this->info("Expired {$count} orders.");
})->purpose('Expire unpaid pickup orders past their pickup time');
