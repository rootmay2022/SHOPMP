@extends('admin.layout')

@section('content')
<h1>Chi tiết đơn hàng #{{ $order->id }}</h1>
<p><strong>Khách hàng:</strong> {{ $order->user->name ?? 'N/A' }}</p>
<p><strong>Trạng thái:</strong> {{ ucfirst($order->status) }}</p>
<p><strong>Ngày tạo:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
<p><strong>Tổng tiền:</strong> {{ number_format($order->total_price) }} VND</p>

<h3>Sản phẩm</h3>
<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Thành tiền</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->items as $item)
        <tr>
            <td>{{ $item->product->name ?? 'N/A' }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->price) }} VND</td>
            <td>{{ number_format($item->price * $item->quantity) }} VND</td>
        </tr>
        @endforeach
    </tbody>
</table>

<form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" style="margin-top:20px;">
    @csrf
    <label for="status">Cập nhật trạng thái:</label>
    <select name="status" id="status">
        <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Chờ xử lý</option>
        <option value="processing" {{ $order->status=='processing'?'selected':'' }}>Đang xử lý</option>
        <option value="completed" {{ $order->status=='completed'?'selected':'' }}>Hoàn thành</option>
        <option value="cancelled" {{ $order->status=='cancelled'?'selected':'' }}>Đã hủy</option>
    </select>
    <button type="submit">Cập nhật</button>
</form>
@endsection
