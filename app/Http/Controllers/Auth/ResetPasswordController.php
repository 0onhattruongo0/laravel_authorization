<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;


class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', 'min:8'],
        ];
    }

    protected function validationErrorMessages()
    {
        return [
            'token.required' => 'Token không được để trống',
            'email.requered' => 'Email không được để trống',
            'email.email' => 'Định dạng email không đúng',
            'password.required' => 'Mật khẩu không được để trống',
            'password.confirmed' => 'Mật khẩu xác nhận không trùng khớp',
            'password.min' => 'Mật khẩu ít nhất 8 ký tự',
        ];
    }
}
