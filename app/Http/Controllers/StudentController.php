<?php
// 20251021
namespace App\Http\Controllers;

use App\Student;
use App\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * 学生一覧表示
     * GET /students
     */
    public function index(Request $request)
    {
        // 検索パラメータの取得
        $name = $request->input('name');
        $grade = $request->input('grade');
        
        // 学生データの取得（検索機能付き）
        $query = Student::query();
        
        // 名前で検索
        if ($name) {
            $query->where('name', 'like', "%{$name}%");
        }
        
        // 学年で検索
        if ($grade) {
            $query->where('grade', $grade);
        }
        
        // 学年順、ID順で並び替え
        $students = $query->orderBy('grade', 'asc')
                         ->orderBy('id', 'asc')
                         ->paginate(10);
        
        return view('students.index', compact('students', 'name', 'grade'));
    }
}