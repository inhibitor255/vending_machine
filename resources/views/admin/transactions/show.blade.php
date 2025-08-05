<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaction Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-700"><strong>Transaction ID:</strong> {{ $transaction->id }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-700"><strong>User:</strong> {{ $transaction->user->name }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-700"><strong>Total Amount:</strong> {{ $transaction->total_amount }}</p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-700"><strong>Date:</strong> {{ $transaction->created_at->format('Y-m-d H:i') }}</p>
                    </div>

                    <h3 class="font-semibold text-lg text-gray-800 leading-tight mb-2">Products in this Transaction:</h3>
                    @if ($transaction->products->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price at Purchase</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($transaction->products as $product)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $product->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $product->pivot->quantity }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $product->pivot->price_at_purchase }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>No products associated with this transaction.</p>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('transactions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to Transactions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
