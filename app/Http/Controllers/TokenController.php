<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('auth.tokens.index', ['tokens' => auth()->user()->tokens]);
    }

    /**
     * Генерирует новый токен
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generate()
    {
        $user = auth()->user();

        $plainTextToken = $user->createToken($user->name . '_auth_token_ui_call')->plainTextToken;

        return back()->with(['new_token' => $plainTextToken]);
    }

    /**
     * Отзывает токены пользователя
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete()
    {
        auth()->user()->tokens()->delete();

        return back()->with(['success' => 'Выданные ранее токены отозваны']);
    }


}
