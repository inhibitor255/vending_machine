@extends('layouts.app')

@section('content')
    <h1>Edit Product</h1>
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="{{ $product->name }}">
        <label for="price">Price:</label>
        <input type="text" name="price" id="price" value="{{ $product->price }}">
        <label for="quantity">Quantity:</label>
        <input type="text" name="quantity" id="quantity" value="{{ $product->quantity }}">
        <button type="submit">Update Product</button>
    </form>
@endsection
