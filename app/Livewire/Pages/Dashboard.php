<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $recentTransactions;
    public $totalRevenue;
    public $totalTransactionsCount;
    public $myTotalSpent;

    public function mount()
    {
        if (Auth::user()->isAdmin()) {
            $this->recentTransactions = Transaction::with(['user', 'products'])->latest()->take(5)->get();
            $this->totalRevenue = Transaction::sum('total_amount');
            $this->totalTransactionsCount = Transaction::count();
        } else {
            $this->recentTransactions = Auth::user()->transactions()->with('products')->latest()->take(5)->get();
            $this->myTotalSpent = Auth::user()->transactions()->sum('total_amount');
        }
    }

    public function render()
    {
        return view('livewire.pages.dashboard');
    }
}