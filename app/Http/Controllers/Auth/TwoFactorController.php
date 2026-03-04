<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class TwoFactorController extends Controller
{
    public function create()
    {
        return view('auth.two-factor');
    }

    public function store(Request $request): RedirectResponse
    {
        $throttleKey = '2fa:' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, maxAttempts: 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'code' => "Muitas tentativas. Tente novamente em {$seconds} segundos.",
            ]);
        }

        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $userId = $request->session()->get('auth.2fa_pending_user_id');
        $user   = User::find($userId);

        if (! $user) {
            return redirect()->route('login');
        }

        $codeMatches = hash_equals((string) $user->two_factor_code, $request->input('code'));
        $notExpired  = $user->two_factor_expires_at && $user->two_factor_expires_at->isFuture();

        if (! $codeMatches || ! $notExpired) {
            RateLimiter::hit($throttleKey, decay: 60);

            throw ValidationException::withMessages([
                'code' => 'Código inválido ou expirado.',
            ]);
        }

        RateLimiter::clear($throttleKey);
        $user->clearTwoFactorCode();

        $remember = $request->session()->pull('auth.2fa_remember', false);
        $request->session()->forget('auth.2fa_pending_user_id');

        Auth::login($user, $remember);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }
}
