<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <!-- スマホやタブレットで見た時に、画面サイズに合わせて表示 -->
    <!-- width=device-width: 画面の幅に合わせる -->
    <!-- initial-scale=1.0: 初期の拡大率を100%に -->
    <title>@yield('title', '学生成績管理システム')</title>
    <!-- ブラウザのタブに表示されるタイトル -->
    <!-- @yield('title', 'デフォルト値'): 各画面でタイトルを変更できる -->
    <!-- 設定しない場合は「学生成績管理システム」と表示 -->
    
    <style>
        /* リセットCSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        /* * セレクター */
        /* すべての要素に適用される */
        /* HTMLのデフォルトの余白をリセット */
        
        body {
            font-family: "Hiragino Kaku Gothic ProN", "ヒラギノ角ゴ ProN W3", "メイリオ", Meiryo, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
        }
        /* "Hiragino Kaku Gothic ProN": Mac標準の美しい日本語フォント */
        /* "メイリオ": Windows標準の日本語フォント */
        /* sans-serif: どれもない場合の最終手段（ゴシック体） */

        /* ヘッダー */
        .header {
            background-color: #4a90e2;
            color: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        /* remとは？ - 1rem = ルート要素（html）のフォントサイズ 通常、1rem = 16px */
        /* box-shadow:影をつける（立体感を出す） */
        
        .header h1 {
            font-size: 1.5rem;
            font-weight: normal;
        }
        
        .header-user {
            margin-top: 0.5rem;
            font-size: 0.9rem;
        }
        
        /* ナビゲーション */
        .nav {
            background-color: #357abd;
            padding: 0.5rem 2rem;
        }
        
        .nav ul {
            list-style: none;
            display: flex;
            gap: 1.5rem;
        }
        
        .nav a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            display: block;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        
        .nav a:hover {
            background-color: rgba(255,255,255,0.1);
        }
        
        /* メインコンテンツ */
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .content {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        /* フラッシュメッセージ */
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
            border-left: 4px solid;
        }
        
        .alert-success {
            background-color: #d4edda;
            border-color: #28a745;
            color: #155724;
        }
        
        .alert-error {
            background-color: #f8d7da;
            border-color: #dc3545;
            color: #721c24;
        }
        
        .alert-info {
            background-color: #d1ecf1;
            border-color: #17a2b8;
            color: #0c5460;
        }
        /* .alert-success 成功メッセージ 緑色 */
        /* .alert-error エラーメッセージ 赤色 */
        /* .alert-info 情報メッセージ 青色 */
        
        /* ボタン */
        .btn {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            font-size: 1rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            transition: opacity 0.3s;
        }
        
        .btn:hover {
            opacity: 0.8;
        }
        
        .btn-primary {
            background-color: #4a90e2;
            color: white;
        }
        
        .btn-success {
            background-color: #28a745;
            color: white;
        }
        
        .btn-warning {
            background-color: #ffc107;
            color: #333;
        }
        
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        
        .btn-sm {
            padding: 0.25rem 0.75rem;
            font-size: 0.875rem;
        }
        /* .btn-primary メインアクション 青色 登録ボタン */
        /* .btn-success 成功・登録 緑色 保存ボタン */
        /* .btn-warning 警告・編集 黄色 編集ボタン */
        /* .btn-danger 危険・削除 赤色 削除ボタン */
        /* .btn-secondary サブアクション グレー キャンセルボタン */
        /* .btn-sm = Small（小さい）ボタン 20251001ここから */  

        /* テーブル */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        /* border-collapse: collapse; セルの枠線を1本にまとめる */
        
        table th,
        table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        
        table tr:hover {
            background-color: #f8f9fa;
        }
        
        /* フォーム */
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }
        
        .form-control {
            width: 100%;
            padding: 0.5rem;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #4a90e2;
            box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
        }
        
        /* エラーメッセージ */
        .error {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        
        /* ページタイトル */
        .page-title {
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #4a90e2;
        }
        
        /* フッター */
        .footer {
            text-align: center;
            padding: 2rem;
            color: #666;
            margin-top: 3rem;
        }
        
        /* ユーティリティ */
        /* ユーティリティクラスとは？ */
        /* 1つの機能だけを持つクラスでどこでも使い回せる */
        .text-center {
            text-align: center;
        }
        
        .mb-1 { margin-bottom: 0.5rem; }
        .mb-2 { margin-bottom: 1rem; }
        .mb-3 { margin-bottom: 1.5rem; }
        .mt-1 { margin-top: 0.5rem; }
        .mt-2 { margin-top: 1rem; }
        .mt-3 { margin-top: 1.5rem; }
        
        .d-flex {
            display: flex;
            gap: 0.5rem;
        }
        
        .justify-between {
            justify-content: space-between;
        }
        
        .align-center {
            align-items: center;
        }
    </style>    
        
</html>

