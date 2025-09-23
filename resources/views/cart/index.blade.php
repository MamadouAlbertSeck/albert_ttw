@extends('layouts.app')

@section('title', 'Panier')

@section('content')
<h1 class="text-2xl font-bold mb-4">Votre Panier</h1>

@if(count($cart) > 0)
<form action="{{ route('cart.update') }}" method="POST">
    @csrf
    <table class="w-full bg-white rounded shadow mb-4">
        <thead class="bg-gray-200">
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart as $id => $item)
            <tr>
                <td>{{ $item['name'] }}</td>
                <td>
                    <input type="number" name="quantities[{{ $id }}]" value="{{ $item['quantity'] }}" min="1" class="border px-2 py-1 w-16">
                </td>
                <td>{{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} CFA</td>
                <td>
                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                        @csrf
                        <button class="bg-red-500 text-white px-2 py-1 rounded">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <button type="submit" class="bg-gray-700 text-white px-3 py-1 rounded">Mettre à jour le panier</button>
</form>

<p class="text-xl font-bold mt-4">Total : {{ number_format($total, 0, ',', ' ') }} CFA</p>

@else
<p>Votre panier est vide.</p>
@endif
@endsection
