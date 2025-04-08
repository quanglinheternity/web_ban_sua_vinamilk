<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // dd(Auth::user()->name);
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng.',
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('auth/login');
    }
    public function showRegistrationForm()
    {
        // dd('adsa');
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Vui lý nhập tên khách hàng',
            'email.required' => 'Vui lý nhập email',
            'password.required' => 'Vui lý nhập mật khuẩn',
        ]);

        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        //     'role' => User::ROLE_USER,
        // ]);
        // Tạo mã xác minh
        $otp = rand(100000, 999999);
        // Lưu tạm thông tin vào session
        Session::put('register_data', $request->all());
        Session::put('otp_code', $otp);
         // Gửi mail
        Mail::raw("Mã xác thực đăng ký của bạn là: $otp", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Mã xác thực đăng ký');
        });
        // Đăng nhập ngay sau khi đăng ký (tùy chọn)
        // return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
        // auth()->login($user);
        // return redirect()->route('admin.dashboard');
        return redirect()->route('verifyOtpForm')->with('success', 'Đã gửi mã xác thực đến email.');
    }
    public function verifyOtpForm()
    {
        return view('auth.verifyOtpForm');
    }
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',

        ], [
            'otp.required' => 'Vui lý nhập mã xác thức',

        ]);

        if ($request->otp == Session::get('otp_code')) {
            $data = Session::get('register_data');

            // Tạo user
            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]);

            // Xoá session
            Session::forget(['otp_code', 'register_data']);

            return redirect()->route('login')->with('success', 'Đăng ký thành công!');
        } else {
            return back()->withErrors(['otp' => 'Mã xác thực không đúng!']);
        }
    }

}
