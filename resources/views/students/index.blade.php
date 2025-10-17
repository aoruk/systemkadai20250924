@extends('layouts.app')
<!-- 20251006 -->
@section('title', '学生表示')

@section('styles')
<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e2e8f0;
    }

    .page-header h1 {
        font-size: 28px;
        color: #2d3748;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    /* gap:Flexbox や Grid レイアウト内の要素間の 間隔（余白） を指定する */
    /* ← 子要素の間に12pxの隙間を作る */

    .header-actions {
        display: flex;
        gap: 12px;
    }

    .search-section {
        background: white;
        padding: 24px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
    }

    .search-section h2 {
        font-size: 18px;
        color: #2d3748;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .search-form {
        display: flex;
        gap: 12px;
        align-items: flex-end;
        flex-wrap: wrap;
    }
    /* align-items: flex-end; Flexコンテナ内の子要素を 縦方向（交差軸）の下端 に揃える */
    /* flex-wrap: wrap; 画面幅が狭いときに、要素を 次の行に折り返す */

    .search-field {
        flex: 1;
        min-width: 200px;
    }

    .search-field label {
        display: block;
        font-size: 14px;
        color: #4a5568;
        margin-bottom: 6px;
        font-weight: 500;
    }

    .search-field input,
    .search-field select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #cbd5e0;
        border-radius: 6px;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .search-field input:focus,
    .search-field select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .search-buttons {
        display: flex;
        gap: 8px;
    }

    .table-section {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    /* overflow: hidden; overflow は、要素の内容が領域からはみ出した場合の表示方法を指定する */
    /* overflow の値 */
    /* overflow: visible;   はみ出た部分も表示（デフォルト）
       overflow: hidden;    はみ出た部分を隠す（採用）
       overflow: scroll;    スクロールバーを常に表示
       overflow: auto;      必要に応じてスクロールバー表示 */ 

    .table-header {
        padding: 20px 24px;
        background: #f7fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-header h2 {
        font-size: 18px;
        color: #2d3748;
        margin: 0;
    }

    .student-count {
        font-size: 14px;
        color: #718096;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }
    /* border-collapse: collapse; テーブルのセル間の境界線をどう表示するかを指定する */
    /* セルとセルの境界線が 1つに統合 される */

    /* - テーブルヘッダー */
    thead {
        background: #f7fafc;
        border-bottom: 2px solid #e2e8f0;
    }

    th {
        padding: 16px 24px;
        text-align: left;
        font-size: 14px;
        font-weight: 600;
        color: #4a5568;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    /* text-transform: uppercase; テキストを大文字に変換する */
    /* letter-spacing: 0.5px; 文字と文字の間隔（字間）を指定する */

    tbody tr {
        border-bottom: 1px solid #e2e8f0;
        transition: background-color 0.2s;
    }

    tbody tr:hover {
        background: #f7fafc;
    }

    tbody tr:last-child {
        border-bottom: none;
    }

    td {
        padding: 16px 24px;
        color: #2d3748;
        font-size: 14px;
    }

    .student-name {
        font-weight: 500;
        color: #2d3748;
    }

    .student-year {
        display: inline-block;
        padding: 4px 12px;
        background: #667eea;
        color: white;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 500;
    }

    .actions-cell {
        text-align: right;
    }

    .empty-state {
        padding: 60px 24px;
        text-align: center;
        color: #718096;
    }

    .empty-state-icon {
        font-size: 48px;
        margin-bottom: 16px;
    }

    .empty-state h3 {
        font-size: 18px;
        color: #4a5568;
        margin-bottom: 8px;
    }

    .empty-state p {
        font-size: 14px;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .search-form {
            flex-direction: column;
        }

        .search-field {
            width: 100%;
        }

        table {
            font-size: 13px;
        }

        th, td {
            padding: 12px 16px;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="page-header">
        <h1>👥 学生表示</h1>
        <div class="header-actions">
            <a href="{{ route('menu') }}" class="btn btn-secondary">
                メニューへ戻る
            </a>
        </div>
    </div>

    <!-- 検索セクション -->
    <div class="search-section">
        <h2>🔍 検索フォーム</h2>
        <form action="{{ route('students.index') }}" method="GET" class="search-form">
            <div class="search-field">
                <label for="name">学生名</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    placeholder="名前で検索..."
                    value="{{ request('name') }}"
                >
            </div>

            <div class="search-field">
                <label for="year">学年</label>
                <select id="year" name="year">
                    <option value="">すべて</option>
                    <option value="1" {{ request('year') == '1' ? 'selected' : '' }}>1年生</option>
                    <option value="2" {{ request('year') == '2' ? 'selected' : '' }}>2年生</option>
                    <option value="3" {{ request('year') == '3' ? 'selected' : '' }}>3年生</option>
                    <option value="4" {{ request('year') == '4' ? 'selected' : '' }}>4年生</option>
                    <option value="5" {{ request('year') == '5' ? 'selected' : '' }}>5年生</option>
                    <option value="6" {{ request('year') == '6' ? 'selected' : '' }}>6年生</option>
                </select>
            </div>
            <!-- <option> タグ:選択肢 を定義 -->
            <!-- {{ request('year') == '1' ? 'selected' : '' }} これは三項演算子-->
                <!-- ↓ -->
            <!-- {{ 条件 ? 真の場合 : 偽の場合 }} -->

            <!-- if文で書くと
            if (request('year') == '1') {
                echo 'selected';
            } else {
                echo '';
            } -->

            <!-- request('キー名'):URLのクエリパラメータやPOSTデータを取得 -->
            <!-- 例え
            http://localhost/students?name=山田&year=2
                                      ↑
                                  request('year') = "2" -->

            <div class="search-buttons">
                <button type="submit" class="btn btn-primary">
                    検索
                </button>
                <a href="{{ route('students.index') }}" class="btn btn-secondary">
                    クリア
                </a>
            </div>
        </form>
    </div>

    <!-- テーブルセクション 20251007 -->
    <div class="table-section">
        <div class="table-header">
            <h2>学生表示</h2>
            <span class="student-count">
                全 {{ $students->total() ?? 0 }} 件
            </span>
        </div>
        <!-- {{ $students->total() ?? 0 }}:学生の総件数を表示する（エラー回避付き） -->
        <!-- {{ 値1 ?? 値2 }} これは Null合体演算子（Null Coalescing Operator） -->
        <!-- 値1が存在して null でなければ → 値1を返す -->
        <!-- 値1が存在しないか null なら → 値2を返す -->

        @if($students->count() > 0)
        <!-- 条件分岐 「学生が1件以上いる場合のみテーブルを表示」-->
        <!-- @if($students->count() > 0)
         学生データがある場合に表示
         @endif -->
        <!-- $students->count() とは？ 現在ページの件数 を取得-->
            <table>
                <thead>
                    <tr>
                        <th>学生</th>
                        <th>名前</th>
                        <th>住所</th>
                        <th class="actions-cell">詳細表示</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <!-- ループ処理 -->
                    <!-- $students の各レコードを $student として1つずつ処理 -->
                    <tr>
                        <td>
                            <span class="student-year">{{ $student->year }}年生</span>
                        </td>
                        <td class="student-name">{{ $student->name }}</td>
                        <td>{{ $student->address }}</td>
                        <td class="actions-cell">
                            <a href="{{ route('students.show', $student->id) }}" class="btn btn-primary btn-sm">
                                詳細表示
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- ページネーション -->
            @if($students->hasPages()) <!--「ページが複数ある場合のみページネーションを表示」 -->
            <div style="padding: 20px 24px; border-top: 1px solid #e2e8f0;">
                {{ $students->links() }}
            </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-state-icon">📭</div>
                <h3>学生が見つかりませんでした</h3>
                <p>検索条件を変更してください。</p>
            </div>
        @endif
        <!--  1ページしかない → ページネーション非表示 -->
        <!--  複数ページある → ページネーション表示 -->
        <!--  データなし → 空状態メッセージ -->
    </div>
</div>
@endsection