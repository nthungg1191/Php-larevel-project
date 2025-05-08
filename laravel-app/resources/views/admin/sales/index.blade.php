@extends('layouts.base')

@section('title', 'Quản lý Sales')

@section('content')
<link rel="stylesheet" href="{{ asset('css/ad-category.css') }}">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Quản lý Sales trên Trang Chủ</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card p-4 mb-4">
        <h2 class="mb-3">Thêm Sale mới</h2>
        <form action="{{ route('admin.sales.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Tiêu đề Sale:</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Chọn danh mục:</label>
                <select id="category_id" name="category_id" class="form-select" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="display_type" class="form-label">Chọn kiểu hiển thị:</label>
                <select id="display_type" name="display_type" class="form-select">
                    <option value="latest">Sản phẩm mới nhất</option>
                    <option value="bestseller">Sản phẩm bán chạy</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Thêm</button>
        </form>
    </div>

    <h2 class="mb-3">Danh sách Sale</h2>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Tiêu đề</th>
                    <th>Danh mục</th>
                    <th>Kiểu hiển thị</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                    <tr>
                        <td>{{ $sale->title }}</td>
                        <td>{{ $sale->category->name }}</td>
                        <td>{{ $sale->display_type == 'latest' ? 'Sản phẩm mới nhất' : 'Bán chạy nhất' }}</td>
                        <td>
                            <form action="{{ route('admin.sales.destroy', $sale->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
