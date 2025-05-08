@extends('layouts.base')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/ad-category.css') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <div class="container">
        <h2>🛍 Chi tiết đơn hàng #{{ $order->id }}</h2>
        <p><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>

        <p><strong>Tên:</strong> {{ $order->customer_name }}</p>
        <p><strong>Email:</strong> {{ $order->email }}</p>
        <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
        <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
        <p><strong>Phương thức thanh toán:</strong> {{ $order->payment_method ?? 'Chưa xác định' }}</p>
        <p><strong>Trạng thái:</strong>
            @if ($order->status == 'pending')
                <span class="badge bg-warning">Chờ xử lý</span>
            @elseif ($order->status == 'processing')
                <span class="badge bg-primary">Đang xử lý</span>
            @elseif ($order->status == 'completed')
                <span class="badge bg-success">Hoàn thành</span>
            @elseif ($order->status == 'canceled')
                <span class="badge bg-danger">Đã hủy</span>
            @endif
        </p>

        <h4>Sản phẩm trong đơn hàng</h4>
        @if ($order->orderItems && count($order->orderItems) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                        <tr>
                            <td>
                                @if($item->product && $item->product->image_url)
                                <img width="100" src="{{ $item->product->image_url }}" alt="Ảnh sản phẩm">

                                @else
                                    Không có ảnh
                                @endif
                            </td>
                            <td>{{ $item->product->name ?? 'Sản phẩm không tồn tại' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 0, ',', '.') }} VND</td>
                            <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VND</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>❌ Đơn hàng này không có sản phẩm nào.</p>
        @endif


        <h3>Tổng tiền: {{ number_format($order->total_price, 0, ',', '.') }} VND</h3>
        @if ($order->status == 'pending')
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
                Hủy đơn hàng
            </button>
        @endif
        <a href="{{ route('orders.my_orders') }}" class="btn btn-primary">Quay lại</a>
    </div>

    <!-- Modal hủy đơn hàng -->
    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cancelModalLabel">Lý do hủy đơn hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <select name="cancel_reason" class="form-select" required>
                            <option value="">-- Chọn lý do --</option>
                            <option value="Tôi muốn thay đổi địa chỉ nhận hàng">Tôi muốn thay đổi địa chỉ nhận hàng</option>
                            <option value="Tôi không muốn mua nữa">Tôi không muốn mua nữa</option>
                            <option value="Đơn hàng giao quá lâu">Đơn hàng giao quá lâu</option>
                            <option value="Tôi tìm thấy giá rẻ hơn ở nơi khác">Tôi tìm thấy giá rẻ hơn ở nơi khác</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection