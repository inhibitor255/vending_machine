<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Purchase Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">{{ $product->name }}</h3>
                    <p class="mt-1 text-sm text-gray-600">{{ __('Price') }}: ${{ $product->price }}</p>
                    <p class="mt-1 text-sm text-gray-600">{{ __('Quantity available') }}: {{ $product->quantity }}</p>

                    <form action="{{ route('products.purchase', $product->id) }}" method="POST" class="mt-6">
                        @csrf
                        <div class="flex items-center">
                            <label for="quantity" class="block font-medium text-sm text-gray-700 mr-4">{{ __('Quantity') }}</label>
                            <input type="number" name="quantity" id="quantity" min="1" max="{{ $product->quantity }}" value="1" class="block w-20 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                {{ __('Back') }}
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Purchase') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
