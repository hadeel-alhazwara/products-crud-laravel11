@extends('layout.app')

@section('title','Show Product')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Product Details</h2>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{ $product->name }}</h4>
            <p class="card-text"><strong>Price:</strong> {{ $product->price }}</p>
            <p class="card-text"><strong>Description:</strong> {{ $product->description }}</p>
            <p class="card-text">
                <strong>Status:</strong>
                <span class="badge bg-{{ $product->status == 'active' ? 'success' : 'secondary' }}">
                    {{ $product->status }}
                </span>
            </p>
            <p class="card-text"><strong>Created At:</strong> {{ $product->created_at->format('d M, Y') }}</p>
        </div>
        <div class="card-footer">
            <a href="{{ route('products.edit', $product->product_id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
@endsection
