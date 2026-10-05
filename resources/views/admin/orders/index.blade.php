@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white font-display">Orders</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-gold">Back to Dashboard</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-dark table-hover">
            <thead class="table-gold">
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Shipping Address</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td class="text-white fw-semibold">#{{ $order->id }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ $order->customer_email }}</td>
                        <td>
                            @if ($order->customer_phone)
                                <small class="text-muted-raven">{{ $order->customer_phone }}</small>
                            @else
                                <small class="text-muted">N/A</small>
                            @endif
                        </td>
                        <td>
                            @if ($order->shipping_address)
                                <small class="text-muted-raven">{{ Str::limit($order->shipping_address, 50) }}</small>
                            @else
                                <small class="text-muted">N/A</small>
                            @endif
                        </td>
                        <td>{{ $order->items->sum('quantity') }}</td>
                        <td class="text-gold fw-semibold">${{ number_format($order->total, 2) }}</td>
                        <td>
                            <span @class([
                                'badge',
                                'bg-warning text-dark' => $order->status === 'pending',
                                'bg-info text-dark' => $order->status === 'processing',
                                'bg-success' => $order->status === 'completed',
                                'bg-danger' => $order->status === 'cancelled',
                            ])>
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-gold">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted-raven py-4">No orders yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    .table-gold {
        background-color: rgba(212, 175, 55, 0.1);
        color: #d4af37;
    }

    .btn-gold {
        background-color: #d4af37;
        color: #09090b;
        border-color: #d4af37;
    }

    .btn-outline-gold {
        color: #d4af37;
        border-color: #d4af37;
    }

    .btn-outline-gold:hover {
        background-color: rgba(212, 175, 55, 0.1);
        color: #d4af37;
    }
</style>
@endsection
