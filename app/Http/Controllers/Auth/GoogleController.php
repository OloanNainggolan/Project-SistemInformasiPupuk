<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $gUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal login dengan Google: ' . $e->getMessage());
        }

        // Temukan user berdasarkan email
        $user = User::where('email', $gUser->getEmail())->first();

        $isNew = false;
        if (! $user) {
            $isNew = true;
            // Create minimal user but DO NOT finalize until required fields filled
            $fullName = $gUser->getName() ?? $gUser->getNickname() ?? 'Pengguna';
            $email = $gUser->getEmail();
            $username = Str::slug(strstr($email, '@', true) ?: $fullName, '_');

            $user = User::create([
                'name' => $fullName,
                'nama_lengkap' => null,
                'username' => $username,
                'email' => $email,
                'password' => bcrypt(Str::random(40)),
                'google_id' => $gUser->getId(),
                'foto' => $gUser->getAvatar() ?? null,
                // leave other required fields null to force completion step
                'alamat' => null,
                'alamat_balai_desa' => null,
                'no_telp' => null,
            ]);
        } else {
            // Update google_id & foto jika belum ada
            $updated = false;
            if (empty($user->google_id)) {
                $user->google_id = $gUser->getId();
                $updated = true;
            }
            if (empty($user->foto) && $gUser->getAvatar()) {
                $user->foto = $gUser->getAvatar();
                $updated = true;
            }
            if ($updated) $user->save();
        }

        // If new user or required fields missing, redirect to completion form
        $needsCompletion = $isNew || empty($user->nama_lengkap) || empty($user->alamat) || empty($user->alamat_balai_desa) || empty($user->no_telp);

        // store temporary Google info in session for the completion form
        session(['google_oauth' => [
            'google_id' => $gUser->getId(),
            'name' => $gUser->getName(),
            'email' => $gUser->getEmail(),
            'avatar' => $gUser->getAvatar(),
            'user_id' => $user->id,
        ]]);

        if ($needsCompletion) {
            return redirect()->route('register.complete.show');
        }

        // Otherwise login and go to dashboard
        Auth::login($user, true);
        return redirect()->intended('/dashboard');
    }

    /**
     * Show completion form after Google OAuth
     */
    public function showCompleteRegistration(Request $request)
    {
        $data = session('google_oauth');
        if (! $data) {
            return redirect()->route('login')->with('error', 'Session Google tidak tersedia. Silakan coba lagi.');
        }

        return view('auth.complete_register', ['google' => $data]);
    }

    /**
     * Process completion form and finalize user record
     */
    public function completeRegistration(Request $request)
    {
        $data = session('google_oauth');
        if (! $data) {
            return redirect()->route('login')->with('error', 'Session Google tidak tersedia. Silakan coba lagi.');
        }

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_telp' => 'required|string|max:30',
            'alamat' => 'required|string|max:1000',
            'alamat_balai_desa' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username,' . $data['user_id'] . ',id',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'no_telp.required' => 'No. telepon wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'alamat_balai_desa.required' => 'Balai desa wajib diisi',
        ]);

        $user = User::find($data['user_id']);
        if (! $user) {
            return redirect()->route('login')->with('error', 'User tidak ditemukan.');
        }

        $user->nama_lengkap = $request->input('nama_lengkap');
        $user->no_telp = $request->input('no_telp');
        $user->alamat = $request->input('alamat');
        $user->alamat_balai_desa = $request->input('alamat_balai_desa');
        $user->username = $request->input('username');
        $user->save();

        // finalize: log the user in
        Auth::login($user, true);
        // clear session
        session()->forget('google_oauth');

        return redirect()->intended('/dashboard')->with('success', 'Pendaftaran melalui Google berhasil diselesaikan.');
    }
}
