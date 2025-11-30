@extends('layouts.app')
<!-- 20251005 -->
@section('title', 'メニュー')

@section('styles')
<style>
    .menu-container {
        max-width: 600px;
        margin: 60px auto;
        padding: 40px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .menu-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .menu-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
    }

    .menu-header h1 {
        font-size: 28px;
        color: #2d3748;
        margin-bottom: 8px;
    }

    .menu-header p {
        color: #718096;
        font-size: 14px;
    }

    .menu-buttons {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .menu-btn {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        background: white;
        color: #2d3748;
        text-decoration: none;
        font-size: 16px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    /* transition:アニメーション効果を設定するプロパティ */
    /* cursor:マウスカーソルの形状を指定 */

    .menu-btn:hover {
        border-color: #667eea;
        background: #f7fafc;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
    }

    .menu-btn-icon {
        font-size: 24px;
        margin-right: 16px;
    }

    .menu-btn-content {
        display: flex;
        align-items: center;
        flex: 1;
    }

    .menu-btn-arrow {
        color: #cbd5e0;
        font-size: 20px;
    }

    .menu-btn:hover .menu-btn-arrow {
        color: #667eea;
    }

    .menu-btn-description {
        display: block;
        font-size: 13px;
        color: #a0aec0;
        font-weight: 400;
        margin-top: 4px;
    }

    .logout-section {
        margin-top: 40px;
        padding-top: 30px;
        border-top: 1px solid #e2e8f0;
    }

    .user-info {
        text-align: center;
        margin-bottom: 20px;
        color: #718096;
        font-size: 14px;
    }

    .user-info strong {
        color: #2d3748;
    }

    /* 20251130 追加 */
    button.menu-btn {
    font-family: inherit;
    font-size: inherit;
    text-align: left;
    width: 100%;
    }
</style>
@endsection

@section('content')
<div class="menu-container">
    <div class="menu-header">
        <div class="menu-icon">📚</div>
        <h1>学生成績管理システム</h1>
        <p>メニューから機能を選択してください</p>
    </div>

    <div class="menu-buttons">
        <!-- 学生表示（学生一覧） -->
        <a href="{{ route('students.index') }}" class="menu-btn">
            <div class="menu-btn-content">
                <span class="menu-btn-icon">👥</span>
                <div>
                    <div>学生表示</div>
                    <span class="menu-btn-description">学生一覧の閲覧・検索</span>
                </div>
            </div>
            <span class="menu-btn-arrow">→</span>
        </a>

        <!-- 学生登録 -->
        <a href="{{ route('students.create') }}" class="menu-btn">
            <div class="menu-btn-content">
                <span class="menu-btn-icon">✏️</span>
                <div>
                    <div>学生登録</div>
                    <span class="menu-btn-description">新しい学生の登録</span>
                </div>
            </div>
            <span class="menu-btn-arrow">→</span>
        </a>

        <!-- 学生更新（学年更新） 20251130 修正-->
        <form id="yearUpdateForm" method="POST" action="{{ route('students.updateYear') }}" style="margin: 0; width: 100%;">
            @csrf
            <button type="button" class="menu-btn" onclick="confirmYearUpdate()" style="width: 100%;">
                <div class="menu-btn-content">
                    <span class="menu-btn-icon">🎓</span>
                    <div>
                        <div>学生更新</div>
                        <span class="menu-btn-description">全生徒の学年を進級</span>
                    </div>
                </div>
                <span class="menu-btn-arrow">→</span>
            </button>
        </form>
    </div>

    <div class="logout-section">
        <div class="user-info">
            ログイン中: <strong>{{ Auth::user()->name }}</strong>
        </div>
        <!-- {{ Auth::user()->name }} -->
        <!-- Laravelの認証機能を使ってログイン中のユーザー名を表示 -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-secondary" style="width: 100%;">
                ログアウト
            </button>
        </form>
    </div>
</div>

<script> //20251130
function confirmYearUpdate() {
    if (confirm('全ての学生の学年を1つ上げます。\n• 1年生 → 2年生\n• 2年生 → 3年生\n• 3年生 → 卒業（削除）\n\nこの操作は取り消せません。実行しますか？')) {
        // フォームを送信
        document.getElementById('yearUpdateForm').submit();
    }
}
</script>
@endsection