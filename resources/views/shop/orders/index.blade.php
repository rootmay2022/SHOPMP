@extends('layouts.app')

@section('title', 'Đơn hàng của tôi - Fashion Shop')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Đơn hàng của tôi</h2>

    @if($orders->isEmpty())
        <div class="alert alert-info text-center" role="alert">
            Bạn chưa có đơn hàng nào.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->order_number }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ number_format($order->total, 0, ',', '.') }} VNĐ</td>
                            <td>
                                @php
                                    $statusClass = '';
                                    switch ($order->status) {
                                        case 'pending':
                                            $statusClass = 'badge bg-warning text-dark';
                                            break;
                                        case 'processing':
                                            $statusClass = 'badge bg-info text-dark';
                                            break;
                                        case 'completed':
                                            $statusClass = 'badge bg-success';
                                            break;
                                        case 'cancelled':
                                            $statusClass = 'badge bg-danger';
                                            break;
                                        default:
                                            $statusClass = 'badge bg-secondary';
                                            break;
                                    }
                                @endphp
                                <span class="{{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td>
                                <a href="{{ route('my.orders.show', $order->id) }}" class="btn btn-sm btn-primary">Xem chi tiết</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
