@extends('layouts.base')

@section('title', 'Thông Tin Tài Khoản')

@section('content')
<link rel="stylesheet" href="{{ asset('css/ad-category.css') }}">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<div class="container mt-4">
    <h2>👤 Thông Tin Tài Khoản</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-lg p-4">
        <h4>Thông tin cá nhân</h4>
        <form action="{{ route('user.updateProfile') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Họ và tên</label>
                <input type="text" name="full_name" class="form-control" value="{{ old('full_name', $user->full_name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>

    <div class="card shadow-lg p-4 mt-4">
        <h4>Đổi mật khẩu</h4>
        <form action="{{ route('user.changePassword') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Mật khẩu hiện tại</label>
                <input type="password" name="current_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mật khẩu mới</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Xác nhận mật khẩu mới</label>
                <input type="password" name="new_password_confirmation" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-danger">Đổi mật khẩu</button>
        </form>
    </div>
</div>
@endsection
