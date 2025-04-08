@extends('adminlte::master')

@section('adminlte_css')
    <style>
        .register-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f6f9;
        }
        .register-box {
            width: 400px;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .register-box .card-header {
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
        }
    </style>
@stop

@section('body')
    <div class="register-container">
        <div class="register-box">
            <div class="card">
                <div class="card-header">Đăng Ký</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <!-- Name Field -->
                        <div class="form-group mb-3">
                            <label for="name">Họ và Tên</label>
                            <div class="input-group">
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Nhập họ và tên" value="{{ old('name') }}"  autofocus>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <div class="input-group">
                                <input type="text" name="email" id="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="Nhập email" value="{{ old('email') }}" >
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="form-group mb-3">
                            <label for="password">Mật khẩu</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Nhập mật khẩu" >
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Confirmation Field -->
                        <div class="form-group mb-3">
                            <label for="password_confirmation">Xác nhận mật khẩu</label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="form-control" placeholder="Nhập lại mật khẩu" >
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-block">Đăng Ký</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p>Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a></p>
                </div>
            </div>
        </div>
    </div>
@stop
