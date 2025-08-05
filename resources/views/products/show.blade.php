@extends('layouts.app')

@section('content')
    <h1>{{ $product->name }}</h1>
    <p>Price: {{ $product->price }}</p>
    <p>Quantity: {{ $product->quantity }}</p>
    <a href="{{ route('products.index') }}">Back to Products</a>
@endsection
