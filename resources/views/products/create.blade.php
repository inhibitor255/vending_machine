@extends('layouts.app')

@section('content')
    <h1>Add New Product</h1>
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <label for="name">Name:</label>
        <input type="text" name="name" id="name">
        <label for="price">Price:</label>
        <input type="text" name="price" id="price">
        <label for="quantity">Quantity:</label>
        <input type="text" name="quantity" id="quantity">
        <button type="submit">Add Product</button>
    </form>
@endsection
