@extends('layouts.app')

@section('title', 'Commandes')

@section('content')
<h1 class="text-xl font-bold mb-4">Commandes</h1>

<table class="w-full bg-white rounded shadow">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-2">ID</th>
            <th class="p-2">Client</th>
            <th class="p-2">Total</th>
            <th class="p-2">Statut</th>
            <th class="p-2">Produits</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr class="border-t">
            <td class="p-2">{{ $order->id }}</td>
            <td class="p-2">{{ $order->customer_name }}</td>
            <td class="p-2">{{ number_format($order->total_amount,2) }} CFA</td>
            <td class="p-2">
                <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                    @csrf
                    @method('PATCH')
                    <select name="status" onchange="this.form.submit()" class="border px-1 py-1 rounded">
                        <option value="pending" @if($order->status=='pending') selected @endif>Pending</option>
                        <option value="paid" @if($order->status=='paid') selected @endif>Paid</option>
                        <option value="shipped" @if($order->status=='shipped') selected @endif>Shipped</option>
                        <option value="cancelled" @if($order->status=='cancelled') selected @endif>Cancelled</option>
                    </select>
                </form>
            </td>
            <td class="p-2">
                <ul>
                    @foreach($order->items as $item)
                        <li>{{ $item->product->name }} x {{ $item->quantity }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $orders->links() }}
</div>
@endsection
