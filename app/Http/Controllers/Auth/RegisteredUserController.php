<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'username' => [
                    'required',
                    'string',
                    'min:3',
                    'max:20',
                    'regex:/^[A-Za-z][A-Za-z0-9_]*$/',
                    'unique:users,username',
                ],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    'unique:users,email'
                ],
                'password' => [
                    'required',
                    'confirmed',
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols()
                ],'role' => ['required', 'in:jobber,provider,education'],
            ], [
                // username
                'username.required' => 'กรุณากรอกชื่อผู้ใช้',
                'username.string' => 'ชื่อผู้ใช้ต้องเป็นข้อความ',
                'username.min' => 'ชื่อผู้ใช้ต้องมีอย่างน้อย :min ตัวอักษร',
                'username.max' => 'ชื่อผู้ใช้ต้องไม่เกิน :max ตัวอักษร',
                'username.regex' => 'ชื่อผู้ใช้ต้องขึ้นต้นด้วยตัวอักษร และใช้ได้เฉพาะตัวอักษร, ตัวเลข, และ _ เท่านั้น (ห้ามเว้นวรรคหรืออักขระพิเศษ)',
                'username.unique' => 'ชื่อผู้ใช้นี้ถูกใช้แล้ว',

                // email
                'email.required' => 'กรุณากรอกอีเมล',
                'email.string' => 'อีเมลต้องเป็นข้อความ',
                'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
                'email.max' => 'อีเมลต้องไม่เกิน :max ตัวอักษร',
                'email.unique' => 'อีเมลนี้ถูกใช้งานแล้ว',

                // password
                'password.required' => 'กรุณากรอกรหัสผ่าน',
                'password.confirmed' => 'ยืนยันรหัสผ่านไม่ตรงกัน',
                'password.min' => 'รหัสผ่านต้องมีอย่างน้อย :min ตัวอักษร',
                'password.letters' => 'รหัสผ่านต้องมีตัวอักษรอย่างน้อย 1 ตัว',
                'password.mixed' => 'รหัสผ่านต้องมีทั้งตัวพิมพ์ใหญ่และตัวพิมพ์เล็ก',
                'password.numbers' => 'รหัสผ่านต้องมีตัวเลขอย่างน้อย 1 ตัว',
                'password.symbols' => 'รหัสผ่านต้องมีอักขระพิเศษอย่างน้อย 1 ตัว',
            ]);

            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            event(new Registered($user));

            Auth::login($user);

            return redirect('/')->with([
                'showAuthModal' => true,
                'authForm' => 'verify'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // กลับไปหน้าเดิมพร้อม error และเปิด register modal
            return back()->withErrors($e->errors())->with([
                'showAuthModal' => true,
                'authForm' => 'register'
            ])->withInput();
        }
    }
}
