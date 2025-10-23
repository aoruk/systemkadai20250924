@extends('layouts.app')
<!-- 20251012 -->
@section('title', '学生編集')

@section('styles')
<style>
    .edit-container {
        max-width: 700px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .page-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .page-icon {
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

    .page-header h1 {
        font-size: 28px;
        color: #2d3748;
        margin-bottom: 8px;
    }

    .page-header p {
        color: #718096;
        font-size: 14px;
    }

    .form-card {
        background: white;
        border-radius: 12px;
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        color: #2d3748;
        font-weight: 500;
        font-size: 14px;
    }

    .form-label.required::after {
        content: " *";
        color: #e53e3e;
    }

    .form-input,
    .form-textarea,
    .form-select {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: white;
    }

    .form-input:focus,
    .form-textarea:focus,
    .form-select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-textarea {
        min-height: 100px;
        resize: vertical;
        font-family: inherit;
    }

    .form-input.error,
    .form-textarea.error,
    .form-select.error {
        border-color: #e53e3e;
    }

    .error-message {
        color: #e53e3e;
        font-size: 13px;
        margin-top: 6px;
    }

    .form-help {
        font-size: 13px;
        color: #a0aec0;
        margin-top: 6px;
    }

    .file-input-wrapper {
        position: relative;
    }

    .file-input-custom {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        border: 2px dashed #cbd5e0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #f7fafc;
    }

    .file-input-custom:hover {
        border-color: #667eea;
        background: #edf2f7;
    }

    .file-input-custom.has-file {
        border-color: #667eea;
        background: #eef2ff;
    }

    .file-input-icon {
        font-size: 32px;
        margin-bottom: 12px;
    }

    .file-input-text {
        color: #4a5568;
        font-size: 14px;
    }

    .file-input-text strong {
        color: #667eea;
    }

    .file-name {
        margin-top: 12px;
        padding: 8px 12px;
        background: white;
        border-radius: 6px;
        font-size: 13px;
        color: #2d3748;
        word-break: break-all;
    }
    /* word-break: break-all: 長い単語を強制的に改行する */

    input[type="file"] {
        display: none;
    }
    /* デフォルトのファイル入力欄は非表示 */

    .current-photo {
        margin-top: 12px;
        text-align: center;
    }

    .current-photo-label {
        font-size: 12px;
        color: #718096;
        margin-bottom: 8px;
    }

    .current-photo-img {
        width: 150px;
        height: 150px;
        margin: 0 auto;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .current-photo-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .photo-preview {
        margin-top: 12px;
        text-align: center;
        display: none;
    }

    .photo-preview.active {
        display: block;
    }

    .photo-preview-label {
        font-size: 12px;
        color: #718096;
        margin-bottom: 8px;
    }

    .photo-preview-img {
        width: 150px;
        height: 150px;
        margin: 0 auto;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .photo-preview-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 32px;
    }

    .btn {
        flex: 1;
        padding: 14px 24px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
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

    @media (max-width: 768px) {
        .form-card {
            padding: 24px;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="edit-container">
    <div class="page-header">
        <div class="page-icon">✏️</div>
        <h1>学生情報編集</h1>
        <p>学生の情報を編集します</p>
    </div>

    <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-card">
            <!-- 学生ID（非表示） -->
            <div class="form-group">
                <label class="form-label">学生ID</label>
                <input type="text" class="form-input" value="{{ $student->id }}" disabled>
                <div class="form-help">※ IDは変更できません</div>
            </div>

            <!-- 学年 -->
            <div class="form-group">
                <label for="grade" class="form-label required">学年</label>
                <select name="grade" id="grade" class="form-select @error('grade') error @enderror" required>
                    <option value="">選択してください</option>
                    <option value="1" {{ old('grade', $student->grade) == 1 ? 'selected' : '' }}>1年生</option>
                    <option value="2" {{ old('grade', $student->grade) == 2 ? 'selected' : '' }}>2年生</option>
                    <option value="3" {{ old('grade', $student->grade) == 3 ? 'selected' : '' }}>3年生</option>
                </select>
                @error('grade')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- 名前 -->
            <div class="form-group">
                <label for="name" class="form-label required">氏名</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-input @error('name') error @enderror" 
                    value="{{ old('name', $student->name) }}"
                    placeholder="山田 太郎"
                    required
                >
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
                <div class="form-help">※ 全角文字で入力してください</div>
            </div>

            <!-- 住所 -->
            <div class="form-group">
                <label for="address" class="form-label required">住所</label>
                <textarea 
                    id="address" 
                    name="address" 
                    class="form-textarea @error('address') error @enderror"
                    placeholder="東京都渋谷区〇〇1-2-3&#10;△△マンション101号室"
                    required
                >{{ old('address', $student->address) }}</textarea>
                @error('address')
                    <div class="error-message">{{ $message }}</div>
                @enderror
                <div class="form-help">※ 全角文字で入力してください</div>
            </div>

            <!-- 顔写真 -->
            <div class="form-group">
                <label for="photo" class="form-label">顔写真</label>
                
                <!-- 現在の写真 -->
                @if($student->photo)
                <div class="current-photo">
                    <div class="current-photo-label">現在の写真</div>
                    <div class="current-photo-img">
                        <img src="{{ asset('storage/' . $student->photo) }}" alt="現在の写真">
                    </div>
                </div>
                @endif

                <!-- 20251013 -->
                <div class="file-input-wrapper">
                    <label for="photo" class="file-input-custom" id="fileLabel">
                        <div style="text-align: center;">
                            <div class="file-input-icon">📁</div>
                            <div class="file-input-text">
                                <strong>クリックして写真を選択</strong><br>
                                または、ここにファイルをドロップ
                            </div>
                        </div>
                    </label>
                    <input 
                        type="file" 
                        id="photo" 
                        name="photo" 
                        accept="image/*"
                        onchange="handleFileSelect(this)"
                    >
                    <div id="fileName" class="file-name" style="display: none;"></div>
                </div>

                <!-- 新しい写真のプレビュー -->
                <div class="photo-preview" id="photoPreview">
                    <div class="photo-preview-label">新しい写真のプレビュー</div>
                    <div class="photo-preview-img">
                        <img id="previewImage" src="" alt="プレビュー">
                    </div>
                </div>

                @error('photo')
                    <div class="error-message">{{ $message }}</div>
                @enderror
                <div class="form-help">※ 写真を変更しない場合は選択不要です</div>
            </div>

            <!-- コメント -->
            <div class="form-group">
                <label for="comment" class="form-label">コメント</label>
                <textarea 
                    id="comment" 
                    name="comment" 
                    class="form-textarea @error('comment') error @enderror"
                    placeholder="特記事項があれば入力してください"
                >{{ old('comment', $student->comment) }}</textarea>
                @error('comment')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                💾 更新する
            </button>
            <a href="{{ route('students.show', $student->id) }}" class="btn btn-secondary">
                キャンセル
            </a>
        </div>
    </form>
</div>

<script>
function handleFileSelect(input) {
    const fileLabel = document.getElementById('fileLabel');
    const fileName = document.getElementById('fileName');
    const photoPreview = document.getElementById('photoPreview');
    const previewImage = document.getElementById('previewImage');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // ファイル名表示
        fileName.textContent = `選択されたファイル: ${file.name}`;
        fileName.style.display = 'block';
        fileLabel.classList.add('has-file');
        
        // プレビュー表示
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            photoPreview.classList.add('active');
        };
        reader.readAsDataURL(file);
    }
}
</script>
<!-- 1. ユーザーがファイルを選択
   ↓
2. handleFileSelect(input) 実行
   ↓
3. DOM要素を取得
   ↓
4. ファイルの存在確認
   ↓
5. ファイル名を表示
   ↓
6. 画像をプレビュー表示　-->
@endsection