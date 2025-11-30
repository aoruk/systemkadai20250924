<?php
// 20251104
namespace App\Http\Controllers;

use App\Grade;
use App\Student;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * create() メソッド 成績登録フォーム表示
     * GET /grades/create/{student_id}
     */
    public function create($student_id)
    {
        // 学生データを取得（必須パラメータ）
        $student = Student::findOrFail($student_id);
        return view('grades.create', compact('student'));
    }

    /**
     * store() メソッド 成績登録処理
     * POST /grades/store
     */
    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'grade' => 'required|integer|between:1,3',
            'semester' => 'required|integer|between:1,3',
            'japanese' => 'required|integer|between:1,5',
            'math' => 'required|integer|between:1,5',
            'science' => 'required|integer|between:1,5',
            'social' => 'required|integer|between:1,5',
            'music' => 'required|integer|between:1,5',
            'home_economics' => 'required|integer|between:1,5',
            'english' => 'required|integer|between:1,5',
            'art' => 'required|integer|between:1,5',
            'health' => 'required|integer|between:1,5',
        ], [
            'student_id.required' => '学生を選択してください',
            'student_id.exists' => '選択された学生が存在しません',
            'grade.required' => '学年を選択してください',
            'grade.between' => '学年は1～3の範囲で選択してください',
            'semester.required' => '学期を選択してください',
            'semester.between' => '学期は1～3の範囲で選択してください',
            'japanese.required' => '国語の成績を選択してください',
            'japanese.between' => '国語の成績は1～5の範囲で選択してください',
            'math.required' => '数学の成績を選択してください',
            'math.between' => '数学の成績は1～5の範囲で選択してください',
            'science.required' => '理科の成績を選択してください',
            'science.between' => '理科の成績は1～5の範囲で選択してください',
            'social.required' => '社会の成績を選択してください',
            'social.between' => '社会の成績は1～5の範囲で選択してください',
            'music.required' => '音楽の成績を選択してください',
            'music.between' => '音楽の成績は1～5の範囲で選択してください',
            'home_economics.required' => '家庭科の成績を選択してください',
            'home_economics.between' => '家庭科の成績は1～5の範囲で選択してください',
            'english.required' => '英語の成績を選択してください',
            'english.between' => '英語の成績は1～5の範囲で選択してください',
            'art.required' => '美術の成績を選択してください',
            'art.between' => '美術の成績は1～5の範囲で選択してください',
            'health.required' => '保健体育の成績を選択してください',
            'health.between' => '保健体育の成績は1～5の範囲で選択してください',
        ]);

        // 同じ学生・学年・学期の成績が既に存在しないか重複チェック
        $existingGrade = Grade::where('student_id', $validated['student_id'])
                             ->where('grade', $validated['grade'])
                             ->where('semester', $validated['semester'])
                             ->first();

        if ($existingGrade) {
            return back()
                ->withInput()
                ->withErrors(['duplicate' => 'この学生の同じ学年・学期の成績は既に登録されています。']);
        }

        // 成績データの登録
        $grade = Grade::create($validated);

        return redirect()->route('students.show', $validated['student_id'])
                        ->with('success', '成績を登録しました');
    }

    /** 20251105
     * edit() メソッド 成績編集フォーム表示
     * GET /grades/{id}/edit
     */
    public function edit($id)
    {
        $grade = Grade::with('student')->findOrFail($id);
        return view('grades.edit', compact('grade'));
    }

    /**
     * update() メソッド 成績更新処理
     * PUT /grades/{id}
     */
    public function update(Request $request, $id)
    {
        $grade = Grade::findOrFail($id);

        // バリデーション
        $validated = $request->validate([
            'grade' => 'required|integer|between:1,3',
            'semester' => 'required|integer|between:1,3',
            'japanese' => 'required|integer|between:1,5',
            'math' => 'required|integer|between:1,5',
            'science' => 'required|integer|between:1,5',
            'social' => 'required|integer|between:1,5',
            'music' => 'required|integer|between:1,5',
            'home_economics' => 'required|integer|between:1,5',
            'english' => 'required|integer|between:1,5',
            'art' => 'required|integer|between:1,5',
            'health' => 'required|integer|between:1,5',
        ], [
            'grade.required' => '学年を選択してください',
            'grade.between' => '学年は1～3の範囲で選択してください',
            'semester.required' => '学期を選択してください',
            'semester.between' => '学期は1～3の範囲で選択してください',
            'japanese.required' => '国語の成績を選択してください',
            'japanese.between' => '国語の成績は1～5の範囲で選択してください',
            'math.required' => '数学の成績を選択してください',
            'math.between' => '数学の成績は1～5の範囲で選択してください',
            'science.required' => '理科の成績を選択してください',
            'science.between' => '理科の成績は1～5の範囲で選択してください',
            'social.required' => '社会の成績を選択してください',
            'social.between' => '社会の成績は1～5の範囲で選択してください',
            'music.required' => '音楽の成績を選択してください',
            'music.between' => '音楽の成績は1～5の範囲で選択してください',
            'home_economics.required' => '家庭科の成績を選択してください',
            'home_economics.between' => '家庭科の成績は1～5の範囲で選択してください',
            'english.required' => '英語の成績を選択してください',
            'english.between' => '英語の成績は1～5の範囲で選択してください',
            'art.required' => '美術の成績を選択してください',
            'art.between' => '美術の成績は1～5の範囲で選択してください',
            'health.required' => '保健体育の成績を選択してください',
            'health.between' => '保健体育の成績は1～5の範囲で選択してください',
        ]);

        // 同じ学生・学年・学期の成績が既に存在しないかチェック（自分自身は除外）
        $existingGrade = Grade::where('student_id', $grade->student_id)
                             ->where('grade', $validated['grade'])
                             ->where('semester', $validated['semester'])
                             ->where('id', '!=', $id)
                             ->first();

        if ($existingGrade) {
            return back()
                ->withInput()
                ->withErrors(['duplicate' => 'この学生の同じ学年・学期の成績は既に登録されています。']);
        }

        // 成績データの更新
        $grade->update($validated);

        return redirect()->route('students.show', $grade->student_id)
                        ->with('success', '成績を更新しました');
    }

    /**
     * destroy() メソッド 成績削除処理
     * DELETE /grades/{id}
     */
    public function destroy($id)
    {
        $grade = Grade::findOrFail($id);
        $student_id = $grade->student_id;

        // 成績データの削除
        $grade->delete();

        return redirect()->route('students.show', $student_id)
                        ->with('success', '成績を削除しました');
    }

    /**
     * search() メソッド Ajax成績検索用API
     * GET /grades/search/{student_id}
     * 20251129 追加
    */
    public function search($student_id, Request $request)
    {
        // 学生データを取得
        $student = Student::findOrFail($student_id);
        
        // 成績データのクエリを開始
        $query = Grade::where('student_id', $student_id);
        
        // 学年でフィルタリング
        if ($request->filled('grade_filter')) {
            $query->where('grade', $request->grade_filter);
        }
        
        // 学期でフィルタリング
        if ($request->filled('semester_filter')) {
            $query->where('semester', $request->semester_filter);
        }
        
        // 学年、学期の順で並び替え
        $grades = $query->orderBy('grade', 'asc')
                       ->orderBy('semester', 'asc')
                       ->get();
        
        // JSON形式で返却（Ajax用）
        return response()->json([
            'html' => view('students.partials.grades_table', compact('grades'))->render(),
            'count' => $grades->count()
        ]);
    }
}
