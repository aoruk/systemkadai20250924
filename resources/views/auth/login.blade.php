@extends('layouts.app') 
<!-- 20251106 修正 -->
<!-- @extends と @section
@extends: layouts/app.blade.phpを継承 -->
@section('title', 'ログイン')
<!-- @section('title', 'ログイン'): ブラウザのタブに「ログイン」と表示 -->

@section('styles')
<!-- このページだけのCSSを追加 -->
<!-- app.blade.phpの@yield('styles')に挿入される -->
<style>
    /* ログイン画面専用のスタイル */
    .login-container {
        max-width: 400px;
        margin: 3rem auto;
    }
    
    .login-card {
        background-color: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .login-title {
        text-align: center;
        font-size: 1.5rem;
        margin-bottom: 2rem;
        color: #4a90e2;
    }
    
    .login-logo {
        text-align: center;
        margin-bottom: 1.5rem;
    }
    
    .login-logo-icon {
        width: 80px;
        height: 80px;
        background-color: #4a90e2;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-size: 2rem;
    }
    
    .login-btn {
        width: 100%;
        padding: 0.75rem;
        font-size: 1rem;
        margin-top: 1rem;
    }
    
    .register-link {
        text-align: center;
        margin-top: 1.5rem;
    }
    
    .register-link a {
        color: #4a90e2;
        text-decoration: none;
    }
    
    .register-link a:hover {
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="login-container">
    <div class="login-card">
        {{-- ロゴ --}}
        <div class="login-logo">
            <div class="login-logo-icon">
                📚
            </div>
        </div>
        
        {{-- タイトル --}}
        <h2 class="login-title">学生成績管理システム</h2>
        
        {{-- ログインフォーム --}}
        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <!-- action: 送信先のURL -->
            <!-- route('login.post'): web.phpで定義したルート名 -->
            <!-- Route::post('/login', 'AuthController@login')->name('login.post'); -->
            <!-- method="POST": POSTメソッドで送信 -->
            <!-- @csrf: CSRF保護トークン    -->
            
            {{-- メールアドレス --}}
            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control" 
                    value="{{ old('email') }}"
                    required 
                    autofocus
                    placeholder="example@example.com"
                >
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror

                <!-- value="{{ old('email') }}" -->
                <!-- 最重要：前回入力した値を表示 -->
                 <!-- 1. ユーザーが "test@example.com" を入力
                      2. 送信（パスワードは空）
                         ↓
                      3. バリデーション：パスワード必須エラー
                         ↓
                      4. ログイン画面に戻る
                         ↓
                      5. old('email') が "test@example.com" を返す
                         ↓
                      6. 入力欄に表示される（パスワードだけ入力し直せばOK） -->

                <!-- required:HTML5の属性でブラウザが自動チェック。空では送信できない。 -->
                <!-- autofocus:ページ読み込み時に自動的にフォーカス -->
                <!-- placeholder:入力欄の中に表示されるヒント文字。クリックすると消える。 -->

            </div>
            
            {{-- パスワード --}}
            <div class="form-group">
                <label for="password">パスワード</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control" 
                    required
                    placeholder="パスワードを入力"
                >
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            {{-- ログインボタン --}}
            <button type="submit" class="btn btn-primary login-btn">
                ログイン
            </button>
        </form>
        
        {{-- 新規登録リンク --}}
        <div class="register-link">
            <p>アカウントをお持ちでない方は<a href="{{ route('admin.register') }}">新規登録</a></p>
        </div>
    </div>
</div>
@endsection