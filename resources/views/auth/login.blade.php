@extends('adminlte::master')

@section('adminlte_css')
    <style>
        .login-container { display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f4f6f9; }
        .login-box { width: 360px; padding: 20px; background: #fff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 10px; }
        .login-box .card-header { text-align: center; font-size: 1.5rem; font-weight: bold; }
    </style>
@stop

@section('body')
    <div class="login-container">
        <div class="login-box">
            <div class="card">
                <div class="card-header">Đăng Nhập</div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <div class="input-group">
                                <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                       placeholder="Nhập email" value="{{ old('email') }}"  autofocus>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Mật khẩu</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Nhập mật khẩu">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">Ghi nhớ đăng nhập</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Đăng Nhập</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p>Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a></p>
                    @if (Route::has('password.request'))
                        <p><a href="{{ route('password.request') }}">Quên mật khẩu?</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
