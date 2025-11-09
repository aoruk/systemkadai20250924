<?php
// 20251022
namespace App\Http\Controllers;

use App\Student;
use App\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * index メソッド 学生一覧表示
     * GET /students
     */
    public function index(Request $request)
    {
        // 検索パラメータの取得
        $name = $request->input('name');
        $grade = $request->input('grade');
        // URLパラメータ ?name=山田&grade=1 から値を取得
        // 検索フォームから送られてきたデータを受け取る
        
        // 学生データの取得（検索機能付き）クエリビルダーを準備
        $query = Student::query();
        // データベース検索の準備
        // まだ実行していない（条件を追加できる状態）
        
        // 名前で検索
        if ($name) {
            $query->where('name', 'like', "%{$name}%");
        }
        
        // 学年で検索
        if ($grade) {
            $query->where('grade', $grade);
        }
        
        // 学年順、ID順で並び替え
        // orderBy('grade', 'asc') - 学年の昇順（1年→2年→3年）
        // orderBy('id', 'asc') - ID順（同じ学年内で登録順）
        // paginate(10) - 1ページに10件ずつ表示
        $students = $query->orderBy('grade', 'asc')
                         ->orderBy('id', 'asc')
                         ->paginate(10);
        
        return view('students.index', compact('students', 'name', 'grade'));
    }

    /** 20251022
     * create メソッド 学生登録フォーム表示 データ処理無し
     * GET /students/create
     */
    public function create()
    {
        return view('students.create');
    }

    /**　20251023
     * store メソッド 学生登録処理
     * POST /students/store
     */
    public function store(Request $request)
    {
        // バリデーション（View又仕様書の入出力項目を実装し確認）
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => '氏名を入力してください',
            'name.max' => '氏名は255文字以内で入力してください',
            'address.required' => '住所を入力してください',
            'address.max' => '住所は500文字以内で入力してください',
            'photo.required' => '顔写真を選択してください',
            'photo.image' => '顔写真は画像ファイルを選択してください',
            'photo.mimes' => '顔写真はjpeg、png、jpg、gif形式のファイルを選択してください',
            'photo.max' => '顔写真のファイルサイズは2MB以下にしてください',
        ]);

        // デフォルト値を設定
        $validated['grade'] = 1;      // デフォルトで1年生
        $validated['comment'] = null; // コメントは空
        // 学年とコメントは仕様書に記載がないため、Controller側でデフォルト値を設定する現在の実装は正しい
        // 仕様書には「学年」の入力欄がないため、1年生固定で登録される

        // 画像ファイルの保存
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('students', 'public');
            $validated['photo'] = $path;
        }
        // **詳細な流れ:**

        // 1. `$request->hasFile('photo')` 
        //    - ファイルがアップロードされているかチェック
           
        // 2. `$request->file('photo')`
        //    - アップロードされたファイルを取得
           
        // 3. `->store('students', 'public')`
        //    - `storage/app/public/students/` フォルダに保存
        //    - ファイル名は自動生成（例: `abc123.jpg`）
        //    - 返り値: `students/abc123.jpg`（相対パス）
           
        // 4. `$validated['photo'] = $path`
        //    - パスを配列に追加
        //    - 例: `$validated['photo'] = 'students/abc123.jpg'`
        
        // **保存場所:**
        // ```
        // storage/
        //   app/
        //     public/
        //       students/        ← ここに保存
        //         abc123.jpg
        //         def456.png

        // 学生データの登録
        $student = Student::create($validated);

        return redirect()->route('students.show', $student->id)
                        ->with('success', '学生を登録しました');
    }

     /**
     * show メソッド 学生詳細表示
     * GET /students/{id}
     */
    public function show($id)
    {
        // 学生データと関連する成績データを取得
        $student = Student::with(['grades' => function($query) {
            $query->orderBy('grade', 'asc')
                  ->orderBy('semester', 'asc');
        }])->findOrFail($id);

        // 分解して説明:

        // Student:: - 学生モデルから検索開始
        // with(['grades' => ...]) - Eager Loading（一括読み込み）
        
        // 学生データと一緒に成績データも取得
        // 「grades」= Student モデルに定義されたリレーション
        // 通常のクエリ（N+1問題）を防ぐ
        
        // function($query) { ... } - 成績の取得条件を指定
        
        // orderBy('grade', 'asc') - 学年順（1年→2年→3年）
        // orderBy('semester', 'asc') - 学期順（1学期→2学期→3学期）
        
        // findOrFail($id) - IDで学生を検索
        
        // 見つかれば: 学生データを返す
        // 見つからなければ: 404エラーを表示

        return view('students.show', compact('student'));
    }

    /** 20251024
     * edit メソッド 学生編集フォーム表示
     * GET /students/{id}/edit
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('students.edit', compact('student'));
    }
    // findOrFail($id) - IDで学生を検索（見つからなければ404）
    // 編集フォームに現在のデータを表示するため
    // フォームの各項目に value="{{ $student->name }}" のように表示

    /**
     * update メソッド 学生更新処理
     * PUT /students/{id}
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        // バリデーション
        $validated = $request->validate([
            'grade' => 'required|integer|between:1,3',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'comment' => 'nullable|string|max:1000',
        ], [
            'grade.required' => '学年を選択してください',
            'grade.between' => '学年は1～3の範囲で選択してください',
            'name.required' => '氏名を入力してください',
            'name.max' => '氏名は255文字以内で入力してください',
            'address.required' => '住所を入力してください',
            'address.max' => '住所は500文字以内で入力してください',
            'photo.required' => '顔写真を選択してください',
            'photo.image' => '顔写真は画像ファイルを選択してください',
            'photo.mimes' => '顔写真はjpeg、png、jpg、gif形式のファイルを選択してください',
            'photo.max' => '顔写真のファイルサイズは2MB以下にしてください',
            'comment.max' => 'コメントは1000文字以内で入力してください',
        ]);

        // 新しい画像がアップロードされた場合
        if ($request->hasFile('photo')) {
            // 古い画像を削除
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            
            // 新しい画像を保存
            $path = $request->file('photo')->store('students', 'public');
            $validated['photo'] = $path;
        }

        // 学生データの更新
        $student->update($validated);

        return redirect()->route('students.show', $student->id)
                        ->with('success', '学生情報を更新しました');
    }

    /**
     * destroy メソッド 学生削除処理
     * DELETE /students/{id}
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        // 画像ファイルの削除
        if ($student->photo) {
            Storage::disk('public')->delete($student->photo);
        }

        // 学生データの削除（成績データも連動して削除される）
        $student->delete();

        return redirect()->route('students.index')
                        ->with('success', '学生を削除しました');
    }
}