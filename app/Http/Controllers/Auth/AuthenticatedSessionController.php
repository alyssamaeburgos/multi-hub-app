<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Cookie;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\JsonResponse;
use App\Models\User;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    public function apiLogin(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $token = $request->user()->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $request->user(),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    // public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        // $user = User::where('email', $request->email)->first();

        // $token = $user()->createToken($request->token_name);

        // Ensure the token name is always a string
        // $token = $request->user()->createToken($request->token_name ?? 'auth_token')->plainTextToken;

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);

        // return response()->json([
        //     'message' => 'Login successful',
        //     'token' => $token,
        //     'user' => $request->user(),
        // ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
