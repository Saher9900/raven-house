@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-white font-display">Order #{{ $order->id }}</h2>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-gold">Back to Orders</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card bg-raven-surface border-gold h-100">
                <div class="card-body">
                    <h5 class="text-gold">Customer</h5>
                    <p class="text-white mb-1">{{ $order->customer_name }}</p>
                    <p class="text-muted-raven mb-1">{{ $order->customer_email }}</p>
                    @if ($order->customer_phone)
                        <p class="text-muted-raven mb-0">{{ $order->customer_phone }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-raven-surface border-gold h-100">
                <div class="card-body">
                    <h5 class="text-gold">Order Date</h5>
                    <p class="text-white mb-0">{{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-raven-surface border-gold h-100">
                <div class="card-body">
                    <h5 class="text-gold">Total</h5>
                    <p class="text-white fs-4 fw-bold mb-0">${{ number_format($order->total, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-raven-surface border-gold mb-4">
        <div class="card-body">
            <h5 class="text-gold mb-3">Shipping Address</h5>
            <p class="text-white mb-0 white-space-pre-wrap">
                @if ($order->shipping_address)
                    {{ $order->shipping_address }}
                @else
                    <span class="text-muted-raven">No shipping address provided</span>
                @endif
            </p>
        </div>
    </div>

    <div class="card bg-raven-surface border-gold mb-4">
        <div class="card-body">
            <h5 class="text-gold mb-3">Update Status</h5>
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-flex flex-wrap gap-3 align-items-end">
                @csrf
                @method('PATCH')
                <div>
                    <label for="status" class="form-label text-muted-raven small">Status</label>
                    <select name="status" id="status" class="form-select bg-dark text-white border-secondary">
                        @foreach (['pending', 'processing', 'completed', 'cancelled'] as $status)
                            <option value="{{ $status }}" @selected($order->status === $status)>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-gold">Save Status</button>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-dark table-hover">
            <thead class="table-gold">
                <tr>
                    <th>Product</th>
                    <th>Type</th>
                    <th>Brand</th>
                    <th>Unit Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td class="text-white fw-semibold">{{ $item->product_name }}</td>
                        <td>{{ $item->product_type }}</td>
                        <td>{{ $item->product_brand ?? '-' }}</td>
                        <td class="text-gold">${{ number_format($item->unit_price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="text-gold fw-semibold">${{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    .border-gold {
        border-color: #d4af37 !important;
    }

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
</style>
@endsection
