@extends('layouts.app')
<!-- 20251004 -->
@section('title', '新規登録')

@section('styles')
<style>
    /* 新規登録画面専用のスタイル */
    .register-container {
        max-width: 450px;
        margin: 2rem auto;
    }
    
    .register-card {
        background-color: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .register-title {
        text-align: center;
        font-size: 1.5rem;
        margin-bottom: 2rem;
        color: #4a90e2;
    }
    
    .register-logo {
        text-align: center;
        margin-bottom: 1.5rem;
    }
    
    .register-logo-icon {
        width: 80px;
        height: 80px;
        background-color: #28a745;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-size: 2rem;
    }
    
    .register-btn {
        width: 100%;
        padding: 0.75rem;
        font-size: 1rem;
        margin-top: 1rem;
    }
    
    .back-link {
        text-align: center;
        margin-top: 1.5rem;
    }
    
    .back-link a {
        color: #4a90e2;
        text-decoration: none;
    }
    
    .back-link a:hover {
        text-decoration: underline;
    }
    
    .password-note {
        font-size: 0.875rem;
        color: #666;
        margin-top: 0.25rem;
    }
</style>
@endsection

@section('content')
<div class="register-container">
    <div class="register-card">
        {{-- ロゴ --}}
        <div class="register-logo">
            <div class="register-logo-icon">
                ✍️
            </div>
        </div>
        
        {{-- タイトル --}}
        <h2 class="register-title">新規登録</h2>
        
        {{-- 新規登録フォーム --}}
        <form action="{{ route('admin.register.post') }}" method="POST">
            @csrf
            <!-- action: 送信先のURL -->
            <!-- route('admin.register.post'): web.phpで定義したルート名 -->
            <!-- Route::post('/admin/register', 'AdminController@register')->name('admin.register.post'); -->
            <!-- method="POST": POSTメソッドで送信 -->
            <!-- @csrf: CSRF保護トークン -->
            
            {{-- ユーザー名 --}}
            <div class="form-group">
                <label for="name">ユーザー名</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-control" 
                    value="{{ old('name') }}"
                    required 
                    autofocus
                    placeholder="管理ユーザー01"
                >
                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
                <!-- type="text": テキスト入力 -->
                <!-- name="name": ユーザー名フィールド -->
                <!-- value="{{ old('name') }}" -->
                <!-- 前回入力した値を表示 -->
                <!-- バリデーションエラー時に入力内容を保持 -->
            </div>
            
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
                    placeholder="example@example.com"
                >
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
                <!-- value="{{ old('email') }}" -->
                <!-- 前回入力した値を表示 -->
                <!-- バリデーションエラー時に入力内容を保持 -->
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
                    placeholder="6文字以上のパスワード"
                >
                <p class="password-note">※6文字以上で設定してください</p>
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
                <!-- type="password": 文字を隠す -->
                <!-- パスワードは old() で保持しない（セキュリティのため） -->
            </div>
            
            {{-- パスワード確認 --}}
            <div class="form-group">
                <label for="password_confirmation">パスワード確認</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    class="form-control" 
                    required
                    placeholder="パスワードを再入力"
                >
                @error('password_confirmation')
                    <span class="error">{{ $message }}</span>
                @enderror
                <!-- name="password_confirmation" -->
                <!-- Laravelの confirmed バリデーションルールと連動 -->
                <!-- password フィールドと一致しているかチェック -->
            </div>
            
            {{-- 登録ボタン --}}
            <button type="submit" class="btn btn-success register-btn">
                登録
            </button>
        </form>
        
        {{-- ログイン画面へのリンク --}}
        <div class="back-link">
            <p>既にアカウントをお持ちの方は<a href="{{ route('login') }}">ログイン</a></p>
        </div>
    </div>
</div>
@endsection