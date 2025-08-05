<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class UserTransactionController extends Controller
{
    public function index()
    {
        $transactions = Auth::user()->transactions()->with('products')->latest()->paginate(10);
        return view('user.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $transaction->load(['user', 'products']);
        return view('user.transactions.show', compact('transaction'));
    }
}
