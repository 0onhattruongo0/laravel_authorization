<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    protected function validateEmail(Request $request)
    {
        $request->validate(
            ['email' => 'required|email'],
            [
                'email.requered' => 'Email bắt buộc phải nhập',
                'email.email' => 'Định dạng email chưa đúng'
            ]
    
    );
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            throw ValidationException::withMessages([
                'email' => ['Không tìm thấy người dùng với email phù hợp'],
            ]);
        }

        return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Không tìm thấy người dùng với email phù hợp']);
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {
        return $request->wantsJson()
                    ? new JsonResponse(['message' => 'Đường dẫn thay đổi mật khẩu đã gửi vào email của bạn'], 200)
                    : back()->with('status', 'Đường dẫn thay đổi mật khẩu đã gửi vào email của bạn');
    }
}
