@extends('layouts.app')
<!-- 20251008 -->
@section('title', '学生登録')

@section('styles')
<style>
    .container {
        max-width: 800px;
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

    .header-actions {
        display: flex;
        gap: 12px;
    }

    .form-card {
        background: white;
        padding: 32px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        color: #4a5568;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .form-label.required::after {
        content: ' *';
        color: #e53e3e;
        font-weight: 700;
    }

    .form-input,
    .form-textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #cbd5e0;
        border-radius: 6px;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .form-input:focus,
    .form-textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-input.error,
    .form-textarea.error {
        border-color: #e53e3e;
    }

    .form-textarea {
        resize: vertical;
        font-family: inherit;
        min-height: 80px;
    }

    .form-hint {
        display: block;
        font-size: 13px;
        color: #718096;
        margin-top: 6px;
    }

    .file-upload-wrapper {
        position: relative;
        margin-bottom: 8px;
    }

    .file-input {
        position: absolute;
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        z-index: -1;
    }

    .file-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: #f7fafc;
        border: 2px dashed #cbd5e0;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 14px;
        font-weight: 500;
        color: #4a5568;
    }

    .file-label:hover {
        background: #edf2f7;
        border-color: #a0aec0;
    }

    .file-input:focus + .file-label {
        outline: 2px solid #667eea;
        outline-offset: 2px;
    }

    .file-input.error + .file-label {
        border-color: #e53e3e;
    }

    .file-icon {
        font-size: 20px;
    }

    .file-name {
        display: block;
        margin-top: 8px;
        font-size: 13px;
        color: #718096;
    }

    .image-preview {
        margin-top: 16px;
        padding: 16px;
        background: #f7fafc;
        border-radius: 6px;
        text-align: center;
    }

    .image-preview img {
        max-width: 100%;
        max-height: 300px;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .form-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid #e2e8f0;
    }

    @media (max-width: 768px) {
        .container {
            padding: 20px 15px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .form-card {
            padding: 24px;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .form-actions .btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="page-header">
        <h1>📝 学生登録</h1>
        <div class="header-actions">
            <a href="{{ route('students.index') }}" class="btn btn-secondary">
                学生表示へ戻る
            </a>
        </div>
    </div>

    <div class="form-card">
        <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
         <!-- enctype="multipart/form-data": ファイルアップロードを可能にする設定 -->
            
            @csrf

            <!-- 名前入力 -->
            <div class="form-group">
                <label for="name" class="form-label required">名前</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-input @error('name') error @enderror" 
                    value="{{ old('name') }}"
                    placeholder="例: 山田太郎"
                    required
                >
                <!-- @error('name') error @enderror -->
                <!-- 意味: 条件付きでクラスを追加 -->

                <!-- // バリデーションエラーがない場合 -->
                <!-- <input class="form-input"> -->
                <!-- // バリデーションエラーがある場合 -->
                <!-- <input class="form-input error"> -->

                <!-- ### `value="{{ old('name') }}"` -->
                <!-- #### 動作フロー -->
                <!-- 1. ユーザーが「山田太郎」と入力 -->
                   <!-- ↓ -->
                <!-- 2. 送信ボタンをクリック -->
                   <!-- ↓ -->
                <!-- 3. サーバー側でバリデーションエラー -->
                   <!-- ↓ -->
                <!-- 4. 画面が再表示される -->
                   <!-- ↓ -->
                <!-- 5. old('name') で「山田太郎」を復元 ← ユーザーが再入力不要！ -->
                
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
                <span class="form-hint">全角文字で入力してください</span>
            </div>

            <!-- 住所入力 -->
            <div class="form-group">
                <label for="address" class="form-label required">住所</label>
                <textarea 
                    id="address" 
                    name="address" 
                    class="form-textarea @error('address') error @enderror" 
                    placeholder="例: 東京都渋谷区〇〇1-2-3"
                    required
                >{{ old('address') }}</textarea>
                @error('address')
                    <span class="error-message">{{ $message }}</span>
                @enderror
                <span class="form-hint">全角文字で入力してください</span>
            </div>

            <!-- 顔写真アップロード -->
            <div class="form-group">
                <label for="photo" class="form-label required">顔写真</label>
                <div class="file-upload-wrapper">
                    <input 
                        type="file" 
                        id="photo" 
                        name="photo" 
                        class="file-input @error('photo') error @enderror"
                        accept="image/*"
                        required
                        onchange="previewImage(event)"
                    >
                    <!-- accept="image/*"すべての画像形式（JPEG, PNG, GIF等）← 採用 -->
                    
                    <!-- onchange="previewImage(event)": ファイル選択時にJavaScript関数を実行 -->
                    
                    <!-- function previewImage(event) { -->
                        <!-- const file = event.target.files[0]; // 選択されたファイル -->
                        <!-- // ... プレビュー表示処理 -->
                    <!-- } -->

                    <!-- 流れ: -->
                    <!-- 1.ユーザーがファイルを選択 -->
                    <!-- 2.onchange イベント発火 -->
                    <!-- 3.previewImage() 関数実行 -->
                    <!-- 4.画像プレビュー表示 -->

                    <label for="photo" class="file-label">
                        <span class="file-icon">📁</span>
                        <span>ファイルを選択</span>
                    </label>
                    <span class="file-name" id="fileName">選択されていません</span>
                </div>
                @error('photo')
                    <span class="error-message">{{ $message }}</span>
                @enderror
                <span class="form-hint">JPEG、PNG形式の画像ファイル（最大2MB）</span>
                
                <!-- 画像プレビュー -->
                <div id="imagePreview" class="image-preview" style="display: none;">
                    <img id="preview" src="" alt="プレビュー">
                </div>
            </div>

            <!-- ボタン -->
            <div class="form-actions">
                <a href="{{ route('students.index') }}" class="btn btn-secondary">
                    キャンセル
                </a>
                <button type="submit" class="btn btn-primary">
                    登録する
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// 画像プレビュー機能
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');
    const fileName = document.getElementById('fileName');
    
    if (file) {
        // ファイル名表示
        fileName.textContent = file.name;
        
        // 画像プレビュー
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        fileName.textContent = '選択されていません';
        previewContainer.style.display = 'none';
    }
}
</script>
<!-- 全体の流れ
1. ユーザーが画像ファイルを選択
   ↓
2. previewImage() 関数が実行される
   ↓
3. ファイル名を表示
   ↓
4. 画像データを読み込む
   ↓
5. プレビュー画像として表示 -->
@endsection