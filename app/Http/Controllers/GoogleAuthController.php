<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        // Validasi: pastikan Google OAuth credentials sudah dikonfigurasi
        if (empty(config('services.google.client_id')) || empty(config('services.google.client_secret'))) {
            return redirect()->route('login')->with('error', 
                'Google OAuth belum dikonfigurasi. Silakan hubungi administrator untuk mengisi GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET di file .env'
            );
        }

        try {
            return Socialite::driver('google')->redirect();
        } catch (\Exception $e) {
            \Log::error('Google OAuth Redirect Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Gagal menghubungkan ke Google. Silakan coba lagi.');
        }
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Cari user berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if ($user) {
                // Update existing user
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'provider' => 'google',
                ]);
            } else {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'nama_lengkap' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'provider' => 'google',
                    'password' => Hash::make(Str::random(24)), // Random password
                    'email_verified_at' => now(),
                    // Set default values untuk field required
                    'alamat' => 'Belum diisi',
                    'alamat_balai_desa' => 'Belum diisi',
                    'no_telp' => '0000000000',
                ]);
            }

            // Login user
            Auth::login($user, true);

            // Redirect ke dashboard
            return redirect()->route('dashboard')->with('success', 'Login dengan Google berhasil!');

        } catch (\Exception $e) {
            \Log::error('Google OAuth Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Login dengan Google gagal. Silakan coba lagi.');
        }
    }

    /**
     * API: Redirect to Google OAuth (return URL)
     */
    public function apiRedirectToGoogle()
    {
        // Validasi: pastikan Google OAuth credentials sudah dikonfigurasi
        if (empty(config('services.google.client_id')) || empty(config('services.google.client_secret'))) {
            return response()->json([
                'success' => false,
                'message' => 'Google OAuth belum dikonfigurasi',
                'error' => 'GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET belum diisi di file .env',
                'setup_guide' => url('/') . '/GOOGLE_OAUTH_SETUP.md'
            ], 500);
        }

        try {
            $url = Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
            
            return response()->json([
                'success' => true,
                'url' => $url
            ]);
        } catch (\Exception $e) {
            \Log::error('Google OAuth API Redirect Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat redirect URL',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API: Handle Google OAuth callback
     */
    public function apiHandleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            // Cari user berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if ($user) {
                // Update existing user
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'provider' => 'google',
                ]);
            } else {
                // Create new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'nama_lengkap' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'provider' => 'google',
                    'password' => Hash::make(Str::random(24)),
                    'email_verified_at' => now(),
                    'alamat' => 'Belum diisi',
                    'alamat_balai_desa' => 'Belum diisi',
                    'no_telp' => '0000000000',
                ]);
            }

            // Generate token untuk API
            $token = $user->createToken('google-auth')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login dengan Google berhasil',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->nama_lengkap,
                        'email' => $user->email,
                        'avatar' => $user->avatar,
                        'provider' => $user->provider,
                    ],
                    'token' => $token,
                    'token_type' => 'Bearer',
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Google OAuth API Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Login dengan Google gagal',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
