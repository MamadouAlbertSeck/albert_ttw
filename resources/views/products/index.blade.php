@extends('layouts.app')

@section('title','Products - ALBERT TTW')

@section('content')
  <div class="products-grid">
    @foreach($products as $product)
      <article class="product-card">
        <a href="{{ route('product.show',$product->slug) }}">
          <img src="{{nasset('storage/' . $product->image) }}" alt="{{ $product->name }}">
          <h3>{{ $product->name }}</h3>
          <p class="price">{{ number_format($product->price, 0, ',', ' ')}}</p>
        </a>
      </article>
    @endforeach
  </div>

    {{ $products->links() }}
@endsection 