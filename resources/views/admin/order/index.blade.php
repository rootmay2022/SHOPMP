@extends('admin.layout')

@section('content')
<h1>Danh sách đơn hàng</h1>
<form method="GET" action="" class="row g-3 mb-4">
    <div class="col-md-4">
        <input type="text" name="customer_name" value="{{ request('customer_name') }}" class="form-control" placeholder="Tìm theo tên khách hàng...">
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Lọc</button>
    </div>
</form>

@if(session('success'))
    <div style="color: green; margin-bottom: 10px;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="color: red; margin-bottom: 10px;">
        {{ session('error') }}
    </div>
@endif

<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Mã đơn</th>
            <th>Khách hàng</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            <td>#{{ $order->id }}</td>
            <td>{{ $order->user->name ?? 'N/A' }}</td>
            <td>{{ number_format($order->total_price, 0, ',', '.') }} VND</td>
            <td>
                <span style="padding:4px 8px; background:#eee; border-radius:5px">
                    {{ ucfirst($order->status) }}
                </span>
            </td>
            <td>{{ $order->created_at ? \Carbon\Carbon::parse($order->created_at)->setTimezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i') : '' }}</td>
            <td>
                <a href="{{ route('admin.orders.show', $order->id) }}">Xem</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div style="margin-top:20px;">
    {{ $orders->links() }}
</div>
@endsection
