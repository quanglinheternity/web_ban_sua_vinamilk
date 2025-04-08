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
                    <form method="POST" action="{{ route('verifyOtp') }}">
                        @csrf
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <!-- Name Field -->


                        <!-- Email Field -->
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <div class="input-group">
                                <input type="text" name="email" id="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="Nhập email" value="{{ old('email', Session::get('register_data.email')) }}" >
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- otp Field -->
                        <div class="form-group mb-3">
                            <label for="otp">Mã xác thực</label>
                            <div class="input-group">
                                <input type="otp" name="otp" id="otp"
                                       class="form-control @error('otp') is-invalid @enderror"
                                       placeholder="Nhập mã xác thực" value="{{ old('otp') }}" >
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                @error('otp')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-block">Xác nhận</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p>Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a></p>
                </div>
            </div>
        </div>
    </div>
@stop
