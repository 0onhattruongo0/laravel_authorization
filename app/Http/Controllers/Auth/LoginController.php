<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate(
            [
                $this->username() => 'required|string',
                'password' => 'required|string|min:6',
            ],
            [
                $this->username().'.required' => 'Tên đăng nhập bắt buộc phải nhập',
                $this->username().'.string' => 'Kiểu dữ liệu không hợp lệ',
                'password.required' => 'Mật khẩu bắt buộc phải nhập',
                'password.string' => 'Kiểu dữ liệu không hợp lệ',
                'password.min' => 'Mật khẩu bắt buộc phải từ 6 ký tự',
            ]
        );
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => ['Thông tin đăng nhập không chính xác'],
        ]);
    }

    public function username()
    {
        return 'name';
    }

    protected function credentials(Request $request)
    {
        if(filter_var($request->name, FILTER_VALIDATE_EMAIL)){
            $fielđb = 'email';
        }else{
            $fielđb = 'name';
        }
        $dataArr=[
            $fielđb => $request->name,
            'password' => $request->password
        ];
        return $dataArr;
        // return $request->only($this->username(), 'password');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/login');
    }
}
