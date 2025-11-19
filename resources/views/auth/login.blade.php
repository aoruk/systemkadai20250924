@extends('layouts.app')
<!-- 20251118 修正 -->
@section('title', 'ログイン')

@section('styles')
<style>
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
        <div class="login-logo">
            <div class="login-logo-icon">
                📚
            </div>
        </div>
        
        <h2 class="login-title">学生成績管理システム</h2>
        
        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            
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
            </div>
            
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
            
            <button type="submit" class="btn btn-primary login-btn">
                ログイン
            </button>
        </form>
        
        <div class="register-link">
            <p>アカウントをお持ちでない方は<a href="{{ route('admin.register') }}">新規登録</a></p>
        </div>
    </div>
</div>
@endsection