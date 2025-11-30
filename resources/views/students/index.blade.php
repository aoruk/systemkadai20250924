@extends('layouts.app')
<!-- 20251018 修正 20251128 Ajax対応-->
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
        position: relative; /*20251128 追加*/
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

    /* ローディング表示用スタイル 20251128 追加 */
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 10;
    }
    
    .loading-overlay.active {
        display: flex;
    }
    
    .spinner {
        border: 3px solid #f3f3f3;
        border-top: 3px solid #667eea;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
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

    <!-- 検索セクション 20251128 Ajax対応 -->
    <div class="search-section">
        <h2>🔍 検索フォーム</h2>
        <form id="searchForm" class="search-form"> <!-- 20251128 訂正-->
            @csrf
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

            <!-- 20251021 訂正-->
            <div class="search-field">
                <label for="grade">学年</label>
                <select id="grade" name="grade">
                    <option value="">すべて</option>
                    <option value="1" {{ request('grade') == '1' ? 'selected' : '' }}>1年生</option>
                    <option value="2" {{ request('grade') == '2' ? 'selected' : '' }}>2年生</option>
                    <option value="3" {{ request('grade') == '3' ? 'selected' : '' }}>3年生</option>
                </select>
            </div>

            <div class="search-buttons">
                <button type="submit" class="btn btn-primary">
                    検索
                </button>
                <button type="button" id="clearBtn" class="btn btn-secondary"> <!-- 20251128 訂正-->
                    クリア
                </a>
            </div>
        </form>
    </div>

    <!-- テーブルセクション 20251022 修正 20251128 Ajax対応 -->
    <div class="table-section">
        <!-- ローディング表示 -->
        <div class="loading-overlay" id="loadingOverlay">
            <div class="spinner"></div>
        </div>

        <div class="table-header">
            <div style="display: flex; align-items: center; gap: 12px;">
                <h2>学生表示</h2>
                <!-- ソートボタン -->
                 <button type="button" id="sortBtn" class="btn btn-secondary btn-sm" data-order="asc">
                    学年順 ↑
                </button>
            </div>
            <span class="student-count" id="studentCount">
                全 {{ $students->total() ?? 0 }} 件
            </span>
        </div>

        <!-- テーブルコンテナ 20251128 修正 -->
         <div id="students-table-container">
            @include('students.partials.table', ['students' => $students])
        </div>
    </div>
</div>
@endsection

<!-- 20251128 追加 -->
@section('scripts')
<script>
$(document).ready(function() {
    // CSRFトークンの設定
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // 現在のソート順を保持
    let currentOrder = 'asc';

    // 検索フォームの送信
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        searchStudents();
    });

    // クリアボタン
    $('#clearBtn').on('click', function() {
        $('#name').val('');
        $('#grade').val('');
        currentOrder = 'asc'; // ソート順もリセット
        updateSortButton();
        searchStudents();
    });

    // ソートボタン
    $('#sortBtn').on('click', function() {
        // ソート順を切り替え
        currentOrder = currentOrder === 'asc' ? 'desc' : 'asc';
        updateSortButton();
        sortStudents();
    });

    // ソートボタンの表示更新
    function updateSortButton() {
        const btn = $('#sortBtn');
        if (currentOrder === 'asc') {
            btn.text('学年順 ↑');
            btn.attr('data-order', 'asc');
        } else {
            btn.text('学年順 ↓');
            btn.attr('data-order', 'desc');
        }
    }

    // 検索実行関数
    function searchStudents(page = 1) {
        $('#loadingOverlay').addClass('active');

        const searchData = {
            name: $('#name').val(),
            grade: $('#grade').val(),
            page: page
        };

        $.ajax({
            url: '{{ route("students.search") }}',
            type: 'GET',
            data: searchData,
            dataType: 'json',
            success: function(response) {
                $('#students-table-container').html(response.html);
                $('#studentCount').text('全 ' + response.total + ' 件');
                $('#loadingOverlay').removeClass('active');
            },
            error: function(xhr, status, error) {
                console.error('検索エラー:', error);
                alert('検索中にエラーが発生しました。');
                $('#loadingOverlay').removeClass('active');
            }
        });
    }

    // ソート実行関数
    function sortStudents(page = 1) {
        $('#loadingOverlay').addClass('active');

        const sortData = {
            name: $('#name').val(),      // 検索条件も一緒に送る
            grade: $('#grade').val(),    // 検索条件も一緒に送る
            order: currentOrder,
            page: page
        };

        $.ajax({
            url: '{{ route("students.sort") }}',
            type: 'GET',
            data: sortData,
            dataType: 'json',
            success: function(response) {
                $('#students-table-container').html(response.html);
                $('#studentCount').text('全 ' + response.total + ' 件');
                $('#loadingOverlay').removeClass('active');
            },
            error: function(xhr, status, error) {
                console.error('ソートエラー:', error);
                alert('ソート中にエラーが発生しました。');
                $('#loadingOverlay').removeClass('active');
            }
        });
    }

    // ページネーションのクリックイベント
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        const page = new URL(url).searchParams.get('page');
        searchStudents(page);
    });
});
</script>
@endsection