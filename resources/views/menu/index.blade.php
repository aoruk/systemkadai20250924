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

        <!-- 学生更新（学年更新） -->
        <button type="button" class="menu-btn" onclick="confirmYearUpdate()">
            <div class="menu-btn-content">
                <span class="menu-btn-icon">🎓</span>
                <div>
                    <div>学生更新</div>
                    <span class="menu-btn-description">全生徒の学年を進級</span>
                </div>
            </div>
            <span class="menu-btn-arrow">→</span>
        </button>
    </div>
    <!-- button type="button"なぜ <a> タグではなく <button> タグ？ -->
    <!-- type="button" - 通常のボタン（クリック時に何もしない） -->
    <!-- type="submit" - フォーム送信ボタン（デフォルト） -->
    <!-- type="reset" - フォームリセットボタン -->
    <!-- 例え:<button class="menu-btn" onclick="confirmYearUpdate()"> -->
    <!-- ❌ これだとフォームが送信されてしまう可能性がある -->
    
    <!-- onclick="confirmYearUpdate()" の意味 -->
    <!-- クリックされたら JavaScript関数 confirmYearUpdate() を実行 -->
    <!-- この関数は下部の <script> タグ内で定義されている -->

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

<script>
function confirmYearUpdate() {
    if (confirm('全ての学生の学年を1つ上げます。\nこの操作は取り消せません。実行しますか？')) {
        alert('この機能は今後実装予定です。');
        // TODO: 学年更新処理の実装
        // 実装時は以下のようなformを作成して送信
        // const form = document.createElement('form');
        // form.method = 'POST';
        // form.action = '/students/update-year';
        // document.body.appendChild(form);
        // form.submit();
    }
}
</script>
<!-- 動作の流れ: -->
<!-- ボタンをクリック -->
<!-- confirmYearUpdate() 関数が実行される -->
<!-- confirm() で確認ダイアログを表示 -->
<!-- 「OK」を押したら → alert() でメッセージ表示 -->
<!-- 「キャンセル」を押したら → 何もしない -->
@endsection