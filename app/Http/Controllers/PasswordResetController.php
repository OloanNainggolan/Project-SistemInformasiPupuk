<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\ResetPasswordCodeMail;
use App\Models\PasswordResetCode;
use App\Models\User;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email tidak terdaftar'], 404);
        }

        $code = rand(100000, 999999); // 6 digit code

        PasswordResetCode::where('email', $request->email)->delete();

        PasswordResetCode::create([
            'email' => $request->email,
            'code' => $code,
            'expires_at' => Carbon::now()->addMinutes(5)
        ]);

        Mail::to($request->email)->send(new ResetPasswordCodeMail($code));

        return response()->json(['message' => 'Kode verifikasi telah dikirim']);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required'
        ]);

        $data = PasswordResetCode::where('email', $request->email)
            ->where('code', $request->code)
            ->first();

        if (!$data) {
            return response()->json(['message' => 'Kode salah'], 400);
        }

        if (Carbon::now()->greaterThan($data->expires_at)) {
            return response()->json(['message' => 'Kode telah kedaluwarsa'], 400);
        }

        return response()->json(['message' => 'Kode valid']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'code' => 'required'
        ]);

        $data = PasswordResetCode::where('email', $request->email)
            ->where('code', $request->code)
            ->first();

        if (!$data) {
            return response()->json(['message' => 'Kode salah'], 400);
        }

        $user = User::where('email', $request->email)->first();

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        PasswordResetCode::where('email', $request->email)->delete();

        return response()->json(['message' => 'Password berhasil direset']);
    }
}
