<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::orderByDesc('date')->paginate(20);
        $total = Expense::sum('amount');
        return view('expenses.index', compact('expenses','total'));
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
        ]);
        Expense::create($data);
        return redirect()->route('expenses.index')->with('success','Pengeluaran ditambahkan.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return back()->with('success','Pengeluaran dihapus.');
    }
}
