@extends('layouts.app')
<!-- 20251010 20251129 修正 -->
@section('title', '学生詳細')

@section('styles')
<style>
    .detail-container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e2e8f0;
    }

    .page-header h1 {
        font-size: 24px;
        color: #2d3748;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-header-icon {
        font-size: 28px;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .btn-secondary {
        background: white;
        color: #2d3748;
        border: 2px solid #e2e8f0;
    }

    .btn-secondary:hover {
        border-color: #667eea;
        background: #f7fafc;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 24px;
        margin-bottom: 40px;
    }
    /* display: grid:この要素をグリッドコンテナにします */
    /* grid-template-columns: 300px 1fr */
    /* 左カラム：固定幅300px */
    /* 右カラム：残りのスペース全体（1fr = 1フラクション） */
    /* 例：画面幅が1200pxの場合 → 左300px、右900px */

    .student-card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        text-align: center;
    }

    .student-photo {
        width: 150px;
        height: 150px;
        margin: 0 auto 20px;
        border-radius: 8px;
        overflow: hidden;
        background: #f7fafc;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .student-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .student-photo-placeholder {
        font-size: 60px;
        color: #cbd5e0;
    }

    .student-info {
        text-align: left;
    }

    .info-row {
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e2e8f0;
    }

    .info-row:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .info-label {
        font-size: 12px;
        color: #a0aec0;
        margin-bottom: 6px;
        font-weight: 500;
    }

    .info-value {
        font-size: 16px;
        color: #2d3748;
        font-weight: 500;
    }

    .info-value.address {
        line-height: 1.6;
        white-space: pre-wrap;
    }
    /* white-space: pre-wrap */
    /* テキスト内の改行（\n）や連続する空白を保持 */
    /* 長い行は自動的に折り返す */
    /* <pre>タグのように改行を保持しつつ、画面幅に合わせて折り返す */

    .grades-section {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        position: relative; /* 20251129追加 */
    }

    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .section-header h2 {
        font-size: 20px;
        color: #2d3748;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .grades-table-wrapper {
        overflow-x: auto;
    }
    /* overflow-x: auto */
    /* コンテンツが横幅を超えた場合、必要に応じて横スクロールバーを表示 */
    /* コンテンツが収まる場合はスクロールバーを表示しない */
    /* 縦方向（overflow-y）には影響しない */

    .grades-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .grades-table th,
    .grades-table td {
        padding: 12px;
        text-align: center;
        border: 1px solid #e2e8f0;
    }

    .grades-table thead th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: 500;
        white-space: nowrap;
    }

    .grades-table tbody tr:hover {
        background: #f7fafc;
    }

    .grades-table tbody td {
        color: #2d3748;
    }

    .no-grades {
        text-align: center;
        padding: 60px 20px;
        color: #a0aec0;
    }

    .no-grades-icon {
        font-size: 48px;
        margin-bottom: 16px;
    }

    .no-grades p {
        font-size: 16px;
        margin-bottom: 20px;
    }

    /* 検索フォーム用スタイル 20251129 追加 */
    .grades-search-form {
        display: flex;
        gap: 12px;
        align-items: flex-end;
        margin-bottom: 24px;
        padding: 16px;
        background: #f7fafc;
        border-radius: 8px;
    }

    .grades-search-field {
        flex: 1;
        min-width: 150px;
    }

    .grades-search-field label {
        display: block;
        font-size: 13px;
        color: #4a5568;
        margin-bottom: 6px;
        font-weight: 500;
    }

    .grades-search-field select {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #cbd5e0;
        border-radius: 6px;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .grades-search-field select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .grades-search-buttons {
        display: flex;
        gap: 8px;
    }

    /* ローディング表示用 20251129 追加 */
    .grades-loading-overlay {
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
        border-radius: 12px;
    }

    .grades-loading-overlay.active {
        display: flex;
    }

    .grades-spinner {
        border: 3px solid #f3f3f3;
        border-top: 3px solid #667eea;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
    }

    @media (max-width: 768px) {
        .content-grid {
            grid-template-columns: 1fr;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .action-buttons {
            width: 100%;
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .grades-table {
            font-size: 12px;
        }

        .grades-table th,
        .grades-table td {
            padding: 8px 4px;
        }
    }
</style>
@endsection

@section('content')
<div class="detail-container">
    <div class="page-header">
        <h1>
            <span class="page-header-icon">👤</span>
            学生詳細情報
        </h1>
        <div class="action-buttons">
            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-primary">
                ✏️ 学生編集
            </a>
            <a href="{{ route('students.index') }}" class="btn btn-secondary">
                ← 戻る
            </a>
        </div>
    </div>

    <div class="content-grid">
        <!-- 学生基本情報カード -->
        <div class="student-card">
            <div class="student-photo">
                @if($student->photo)
                    <img src="{{ asset('storage/' . $student->photo) }}" alt="{{ $student->name }}の写真">
                @else
                    <span class="student-photo-placeholder">👤</span>
                @endif
            </div>
            <div class="student-info">
                <div class="info-row">
                    <div class="info-label">学年</div>
                    <div class="info-value">{{ $student->grade }}年生</div>
                </div>
                <div class="info-row">
                    <div class="info-label">氏名</div>
                    <div class="info-value">{{ $student->name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">住所</div>
                    <div class="info-value address">{{ $student->address }}</div>
                </div>
                @if($student->comment)
                <div class="info-row">
                    <div class="info-label">コメント</div>
                    <div class="info-value address">{{ $student->comment }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- 成績一覧セクション 20251011 20251129 Ajax対応 -->
        <div class="grades-section">
            <!-- ローディング表示 -->
            <div class="grades-loading-overlay" id="gradesLoadingOverlay">
                <div class="grades-spinner"></div>
            </div>

            <div class="section-header">
                <h2>
                    📊 成績一覧
                </h2>
                <a href="{{ route('grades.create', $student->id) }}" class="btn btn-primary">
                    ➕ 成績登録
                </a>
            </div>

            <!-- 検索フォーム 20251129 追加 -->
            <form id="gradesSearchForm" class="grades-search-form">
                @csrf
                <div class="grades-search-field">
                    <label for="grade_filter">学年</label>
                    <select id="grade_filter" name="grade_filter">
                        <option value="">すべて</option>
                        <option value="1">1年</option>
                        <option value="2">2年</option>
                        <option value="3">3年</option>
                    </select>
                </div>

                <div class="grades-search-field">
                    <label for="semester_filter">学期</label>
                    <select id="semester_filter" name="semester_filter">
                        <option value="">すべて</option>
                        <option value="1">1学期</option>
                        <option value="2">2学期</option>
                        <option value="3">3学期</option>
                    </select>
                </div>

                <div class="grades-search-buttons">
                    <button type="submit" class="btn btn-primary">
                        検索
                    </button>
                    <button type="button" id="gradesClearBtn" class="btn btn-secondary">
                        クリア
                    </button>
                </div>
            </form>

            <!-- 成績テーブルコンテナ -->
            <div id="grades-table-container">
                @if($student->grades && count($student->grades) > 0)
                    @include('students.partials.grades_table', ['grades' => $student->grades])
                @else
                    <div class="no-grades">
                        <div class="no-grades-icon">📝</div>
                        <p>まだ成績が登録されていません</p>
                        <a href="{{ route('grades.create', $student->id) }}" class="btn btn-primary">
                            最初の成績を登録する
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

<!-- 20251129 -->
@section('scripts')
<script>
$(document).ready(function() {
    // CSRFトークンの設定
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // 成績検索フォームの送信
    $('#gradesSearchForm').on('submit', function(e) {
        e.preventDefault();
        searchGrades();
    });

    // クリアボタン
    $('#gradesClearBtn').on('click', function() {
        $('#grade_filter').val('');
        $('#semester_filter').val('');
        searchGrades();
    });

    // 成績検索実行関数
    function searchGrades() {
        // ローディング表示
        $('#gradesLoadingOverlay').addClass('active');

        // 検索パラメータ
        const searchData = {
            grade_filter: $('#grade_filter').val(),
            semester_filter: $('#semester_filter').val()
        };

        // Ajax通信
        $.ajax({
            url: '{{ route("grades.search", $student->id) }}',
            type: 'GET',
            data: searchData,
            dataType: 'json',
            success: function(response) {
                // テーブルを更新
                $('#grades-table-container').html(response.html);
                
                // ローディング非表示
                $('#gradesLoadingOverlay').removeClass('active');
            },
            error: function(xhr, status, error) {
                console.error('検索エラー:', error);
                alert('検索中にエラーが発生しました。');
                $('#gradesLoadingOverlay').removeClass('active');
            }
        });
    }
});
</script>
@endsection