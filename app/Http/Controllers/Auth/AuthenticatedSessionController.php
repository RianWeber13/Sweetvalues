<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\TwoFactorCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::validate($credentials)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        $user->generateTwoFactorCode();

        try {
            Mail::to($user->email)->send(new TwoFactorCode($user));
        } catch (\Exception $e) {
            \Log::error('2FA email failed: ' . $e->getMessage());
            $user->clearTwoFactorCode();
            throw ValidationException::withMessages([
                'email' => 'Falha ao enviar o código por e-mail. Tente novamente em alguns instantes.',
            ]);
        }

        $request->session()->put('auth.2fa_pending_user_id', $user->id);

        if ($request->boolean('remember')) {
            $request->session()->put('auth.2fa_remember', true);
        }

        return redirect()->route('two-factor.create');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}