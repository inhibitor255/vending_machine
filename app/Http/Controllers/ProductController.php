<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        $sortBy = $request->input('sort_by', 'name');
        $sortDirection = $request->input('sort_direction', 'asc');

        $sortableColumns = ['name', 'price', 'quantity'];
        if (!in_array($sortBy, $sortableColumns)) {
            $sortBy = 'name';
        }

        $query->orderBy($sortBy, $sortDirection);

        $products = $query->paginate(10);

        return view('products.index', compact('products', 'sortBy', 'sortDirection'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Product::create($request->all());
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('products.index');
    }

    public function purchaseView(string $id)
    {
        $product = Product::find($id);
        return view('products.purchase', compact('product'));
    }

    public function purchase(Request $request, string $id)
    {
        $product = Product::find($id);
        $quantity = $request->input('quantity', 1);

        DB::transaction(function () use ($product, $request, $quantity) {
            $product->decrement('quantity', $quantity);

            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'total_amount' => $product->price * $quantity,
            ]);

            $transaction->products()->attach($product->id, [
                'quantity' => $quantity,
                'price_at_purchase' => $product->price,
            ]);
        });

        return redirect()->route('products.index');
    }
}
