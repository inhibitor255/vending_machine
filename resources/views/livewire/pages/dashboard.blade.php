<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                    {{ __('Dashboard Overview') }}
                </h3>

                @if (Auth::user()->isAdmin())
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-blue-100 p-4 rounded-lg shadow">
                            <h4 class="font-semibold text-lg text-blue-800">Total Revenue</h4>
                            <p class="text-2xl text-blue-900">${{ number_format($totalRevenue, 2) }}</p>
                        </div>
                        <div class="bg-green-100 p-4 rounded-lg shadow">
                            <h4 class="font-semibold text-lg text-green-800">Total Transactions</h4>
                            <p class="text-2xl text-green-900">{{ $totalTransactionsCount }}</p>
                        </div>
                        <div class="bg-yellow-100 p-4 rounded-lg shadow">
                            <h4 class="font-semibold text-lg text-yellow-800">Quick Links</h4>
                            <ul class="list-disc list-inside">
                                <li><a href="{{ route('products.index') }}" class="text-yellow-700 hover:underline" wire:navigate>Manage Products</a></li>
                                <li><a href="{{ route('transactions.index') }}" class="text-yellow-700 hover:underline" wire:navigate>Manage Transactions</a></li>
                            </ul>
                        </div>
                    </div>

                    <h4 class="font-semibold text-lg text-gray-800 leading-tight mb-2">Recent Transactions (All Users)</h4>
                    @if ($recentTransactions->count() > 0)
                        <div class="overflow-x-auto mb-6">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($recentTransactions as $transaction)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($transaction->total_amount, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('transactions.show', $transaction) }}" class="text-indigo-600 hover:text-indigo-900 mr-2" wire:navigate>View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>No recent transactions found.</p>
                    @endif
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-purple-100 p-4 rounded-lg shadow">
                            <h4 class="font-semibold text-lg text-purple-800">My Total Spent</h4>
                            <p class="text-2xl text-purple-900">${{ number_format($myTotalSpent, 2) }}</p>
                        </div>
                        <div class="bg-yellow-100 p-4 rounded-lg shadow">
                            <h4 class="font-semibold text-lg text-yellow-800">Quick Links</h4>
                            <ul class="list-disc list-inside">
                                <li><a href="{{ route('user.transactions.index') }}" class="text-yellow-700 hover:underline" wire:navigate>My Transactions</a></li>
                            </ul>
                        </div>
                    </div>

                    <h4 class="font-semibold text-lg text-gray-800 leading-tight mb-2">My Recent Transactions</h4>
                    @if ($recentTransactions->count() > 0)
                        <div class="overflow-x-auto mb-6">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($recentTransactions as $transaction)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($transaction->total_amount, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('user.transactions.show', $transaction) }}" class="text-indigo-600 hover:text-indigo-900 mr-2" wire:navigate>View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>No recent transactions found.</p>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
