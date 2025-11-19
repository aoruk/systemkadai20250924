@extends('layouts.app')
<!-- 20251014 -->
@section('title', '成績登録')

@section('styles')
<style>
    .register-container {
        max-width: 900px;
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

    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 24px;
        padding-bottom: 12px;
        border-bottom: 2px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 24px;
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
    .form-select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-input.error,
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

    .student-info-box {
        background: #f7fafc;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 24px;
    }

    .student-info-box .info-label {
        font-size: 12px;
        color: #718096;
        margin-bottom: 4px;
    }

    .student-info-box .info-value {
        font-size: 18px;
        font-weight: 600;
        color: #2d3748;
    }

    .grades-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
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

        .form-row {
            grid-template-columns: 1fr;
        }

        .grades-grid {
            grid-template-columns: 1fr;
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
<div class="register-container">
    <div class="page-header">
        <div class="page-icon">📊</div>
        <h1>成績登録</h1>
        <p>学生の成績を登録します</p>
    </div>

    <form action="{{ route('grades.store') }}" method="POST">
        @csrf

        <div class="form-card">
            <!-- 学生選択セクション -->
            <div class="section-title">
                👤 学生情報
            </div>

            <!-- 学生は常に固定表示 20251104 修正-->
             <div class="student-info-box">
                <div class="info-label">選択された学生</div>
                <div class="info-value">{{ $student->name }} ({{ $student->grade }}年生)</div>
            </div>
            <input type="hidden" name="student_id" value="{{ $student->id }}">
        </div>

        <div class="form-card">
            <!-- 成績基本情報 -->
            <div class="section-title">
                📅 成績情報
            </div>

            <div class="form-row">
                <!-- 学年 -->
                <div class="form-group">
                    <label for="grade" class="form-label required">学年</label>
                    <select name="grade" id="grade" class="form-select @error('grade') error @enderror" required>
                        <option value="">選択してください</option>
                        <option value="1" {{ old('grade') == 1 ? 'selected' : '' }}>1年生</option>
                        <option value="2" {{ old('grade') == 2 ? 'selected' : '' }}>2年生</option>
                        <option value="3" {{ old('grade') == 3 ? 'selected' : '' }}>3年生</option>
                    </select>
                    @error('grade')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 学期 -->
                <div class="form-group">
                    <label for="semester" class="form-label required">学期</label>
                    <select name="semester" id="semester" class="form-select @error('semester') error @enderror" required>
                        <option value="">選択してください</option>
                        <option value="1" {{ old('semester') == 1 ? 'selected' : '' }}>1学期</option>
                        <option value="2" {{ old('semester') == 2 ? 'selected' : '' }}>2学期</option>
                        <option value="3" {{ old('semester') == 3 ? 'selected' : '' }}>3学期</option>
                    </select>
                    @error('semester')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- 20251015 -->
        <div class="form-card">
            <!-- 各科目の成績 -->
            <div class="section-title">
                📚 各科目の成績
            </div>

            <div class="grades-grid">
                <!-- 国語 -->
                <div class="form-group">
                    <label for="japanese" class="form-label required">国語</label>
                    <select name="japanese" id="japanese" class="form-select @error('japanese') error @enderror" required>
                        <option value="">選択</option>
                        <option value="5" {{ old('japanese') == 5 ? 'selected' : '' }}>5</option>
                        <option value="4" {{ old('japanese') == 4 ? 'selected' : '' }}>4</option>
                        <option value="3" {{ old('japanese') == 3 ? 'selected' : '' }}>3</option>
                        <option value="2" {{ old('japanese') == 2 ? 'selected' : '' }}>2</option>
                        <option value="1" {{ old('japanese') == 1 ? 'selected' : '' }}>1</option>
                    </select>
                    @error('japanese')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 数学 -->
                <div class="form-group">
                    <label for="math" class="form-label required">数学</label>
                    <select name="math" id="math" class="form-select @error('math') error @enderror" required>
                        <option value="">選択</option>
                        <option value="5" {{ old('math') == 5 ? 'selected' : '' }}>5</option>
                        <option value="4" {{ old('math') == 4 ? 'selected' : '' }}>4</option>
                        <option value="3" {{ old('math') == 3 ? 'selected' : '' }}>3</option>
                        <option value="2" {{ old('math') == 2 ? 'selected' : '' }}>2</option>
                        <option value="1" {{ old('math') == 1 ? 'selected' : '' }}>1</option>
                    </select>
                    @error('math')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 理科 -->
                <div class="form-group">
                    <label for="science" class="form-label required">理科</label>
                    <select name="science" id="science" class="form-select @error('science') error @enderror" required>
                        <option value="">選択</option>
                        <option value="5" {{ old('science') == 5 ? 'selected' : '' }}>5</option>
                        <option value="4" {{ old('science') == 4 ? 'selected' : '' }}>4</option>
                        <option value="3" {{ old('science') == 3 ? 'selected' : '' }}>3</option>
                        <option value="2" {{ old('science') == 2 ? 'selected' : '' }}>2</option>
                        <option value="1" {{ old('science') == 1 ? 'selected' : '' }}>1</option>
                    </select>
                    @error('science')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 社会 -->
                <div class="form-group">
                    <label for="social" class="form-label required">社会</label>
                    <select name="social" id="social" class="form-select @error('social') error @enderror" required>
                        <option value="">選択</option>
                        <option value="5" {{ old('social') == 5 ? 'selected' : '' }}>5</option>
                        <option value="4" {{ old('social') == 4 ? 'selected' : '' }}>4</option>
                        <option value="3" {{ old('social') == 3 ? 'selected' : '' }}>3</option>
                        <option value="2" {{ old('social') == 2 ? 'selected' : '' }}>2</option>
                        <option value="1" {{ old('social') == 1 ? 'selected' : '' }}>1</option>
                    </select>
                    @error('social')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 音楽 -->
                <div class="form-group">
                    <label for="music" class="form-label required">音楽</label>
                    <select name="music" id="music" class="form-select @error('music') error @enderror" required>
                        <option value="">選択</option>
                        <option value="5" {{ old('music') == 5 ? 'selected' : '' }}>5</option>
                        <option value="4" {{ old('music') == 4 ? 'selected' : '' }}>4</option>
                        <option value="3" {{ old('music') == 3 ? 'selected' : '' }}>3</option>
                        <option value="2" {{ old('music') == 2 ? 'selected' : '' }}>2</option>
                        <option value="1" {{ old('music') == 1 ? 'selected' : '' }}>1</option>
                    </select>
                    @error('music')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 家庭科 -->
                <div class="form-group">
                    <label for="home_economics" class="form-label required">家庭科</label>
                    <select name="home_economics" id="home_economics" class="form-select @error('home_economics') error @enderror" required>
                        <option value="">選択</option>
                        <option value="5" {{ old('home_economics') == 5 ? 'selected' : '' }}>5</option>
                        <option value="4" {{ old('home_economics') == 4 ? 'selected' : '' }}>4</option>
                        <option value="3" {{ old('home_economics') == 3 ? 'selected' : '' }}>3</option>
                        <option value="2" {{ old('home_economics') == 2 ? 'selected' : '' }}>2</option>
                        <option value="1" {{ old('home_economics') == 1 ? 'selected' : '' }}>1</option>
                    </select>
                    @error('home_economics')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 英語 -->
                <div class="form-group">
                    <label for="english" class="form-label required">英語</label>
                    <select name="english" id="english" class="form-select @error('english') error @enderror" required>
                        <option value="">選択</option>
                        <option value="5" {{ old('english') == 5 ? 'selected' : '' }}>5</option>
                        <option value="4" {{ old('english') == 4 ? 'selected' : '' }}>4</option>
                        <option value="3" {{ old('english') == 3 ? 'selected' : '' }}>3</option>
                        <option value="2" {{ old('english') == 2 ? 'selected' : '' }}>2</option>
                        <option value="1" {{ old('english') == 1 ? 'selected' : '' }}>1</option>
                    </select>
                    @error('english')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 美術 -->
                <div class="form-group">
                    <label for="art" class="form-label required">美術</label>
                    <select name="art" id="art" class="form-select @error('art') error @enderror" required>
                        <option value="">選択</option>
                        <option value="5" {{ old('art') == 5 ? 'selected' : '' }}>5</option>
                        <option value="4" {{ old('art') == 4 ? 'selected' : '' }}>4</option>
                        <option value="3" {{ old('art') == 3 ? 'selected' : '' }}>3</option>
                        <option value="2" {{ old('art') == 2 ? 'selected' : '' }}>2</option>
                        <option value="1" {{ old('art') == 1 ? 'selected' : '' }}>1</option>
                    </select>
                    @error('art')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 保健体育 -->
                <div class="form-group">
                    <label for="health" class="form-label required">保健体育</label>
                    <select name="health" id="health" class="form-select @error('health') error @enderror" required>
                        <option value="">選択</option>
                        <option value="5" {{ old('health') == 5 ? 'selected' : '' }}>5</option>
                        <option value="4" {{ old('health') == 4 ? 'selected' : '' }}>4</option>
                        <option value="3" {{ old('health') == 3 ? 'selected' : '' }}>3</option>
                        <option value="2" {{ old('health') == 2 ? 'selected' : '' }}>2</option>
                        <option value="1" {{ old('health') == 1 ? 'selected' : '' }}>1</option>
                    </select>
                    @error('health')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                💾 成績登録
            </button>
            <a href="{{ route('students.show', $student->id) }}" class="btn btn-secondary">
                キャンセル
            </a>
        </div>
    </form>
</div>
@endsection