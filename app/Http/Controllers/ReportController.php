<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $range = $request->input('range', 'weekly');
        [$start, $end] = $this->rangeToDates($range);

        $income = Order::whereBetween('created_at', [$start, $end])
            ->whereIn('status',['paid','completed'])
            ->sum('grand_total');
        $expenses = Expense::whereBetween('date', [$start->toDateString(), $end->toDateString()])->sum('amount');
        $net = $income - $expenses;

        return view('reports.index', compact('range','start','end','income','expenses','net'));
    }

    public function downloadPdf(Request $request)
    {
        $range = $request->input('range', 'weekly');
        [$start, $end] = $this->rangeToDates($range);

        $orders = Order::whereBetween('created_at', [$start, $end])
            ->whereIn('status',['paid','completed'])
            ->with('items.product','user')
            ->get();
        $income = $orders->sum('grand_total');
        $expenses = Expense::whereBetween('date', [$start->toDateString(), $end->toDateString()])->sum('amount');
        $net = $income - $expenses;

        $pdf = Pdf::loadView('reports.pdf', [
            'orders' => $orders,
            'start' => $start,
            'end' => $end,
            'income' => $income,
            'expenses' => $expenses,
            'net' => $net,
        ]);
        return $pdf->download("laporan-{$range}-{$start->format('Ymd')}-{$end->format('Ymd')}.pdf");
    }

    private function rangeToDates(string $range): array
    {
        if ($range === 'monthly') {
            $start = now()->startOfMonth();
            $end = now()->endOfMonth();
        } else { // weekly by default
            $start = now()->startOfWeek();
            $end = now()->endOfWeek();
        }
        return [$start, $end];
    }
}
