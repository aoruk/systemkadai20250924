<?php
// 20251106
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * ログイン画面表示
     * GET /
     */
    public function showLoginForm()
    {
        // 既にログイン済みの場合はメニューへリダイレクト
        if (Auth::check()) {
            return redirect()->route('menu');
        }
        
        return view('auth.login');
    }

    /**
     * ログイン処理
     * POST /login
     */
    public function login(Request $request)
    {
        // バリデーション
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスの形式が正しくありません',
            'password.required' => 'パスワードを入力してください',
        ]);

        // ログイン試行
        if (Auth::attempt($credentials)) {
            // セッション再生成（セキュリティ対策）
            $request->session()->regenerate();

            return redirect()->intended(route('menu'))
                           ->with('success', 'ログインしました');
        }

        // ログイン失敗
        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'メールアドレスまたはパスワードが正しくありません',
            ]);
    }

    /**
     * ログアウト処理
     * POST /logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // セッション無効化
        $request->session()->invalidate();
        
        // CSRFトークン再生成
        $request->session()->regenerateToken();

        return redirect()->route('login')
                       ->with('success', 'ログアウトしました');
    }
}
