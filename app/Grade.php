<?php
// 20251124
namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    /**
     * テーブル名
     */
    protected $table = 'grades';

    /**
     * 複数代入可能な属性
     */
    protected $fillable = [
        'student_id',
        'grade',
        'semester',
        'japanese',
        'math',
        'science',
        'social',
        'music',
        'home_economics',
        'english',
        'art',
        'health',
    ];

    /**
     * キャストする属性
     */
    protected $casts = [
        'student_id' => 'integer',
        'grade' => 'integer',
        'semester' => 'integer',
        'japanese' => 'integer',
        'math' => 'integer',
        'science' => 'integer',
        'social' => 'integer',
        'music' => 'integer',
        'home_economics' => 'integer',
        'english' => 'integer',
        'art' => 'integer',
        'health' => 'integer',
    ];

    /**
     * リレーション: 成績が属する学生
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * アクセサ: 全科目の合計点を取得
     * 
     * @return int
     */
    public function getTotalScoreAttribute()
    {
        return $this->japanese 
             + $this->math 
             + $this->science 
             + $this->social 
             + $this->music 
             + $this->home_economics 
             + $this->english 
             + $this->art 
             + $this->health;
    }

    /**
     * アクセサ: 全科目の平均点を取得
     * 
     * @return float
     */
    public function getAverageScoreAttribute()
    {
        return round($this->total_score / 9, 2);
    }

    /**
     * スコープ: 学年で絞り込み
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $grade
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGrade($query, $grade)
    {
        return $query->where('grade', $grade);
    }

    /**
     * スコープ: 学期で絞り込み
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $semester
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    /**
     * スコープ: 学生IDで絞り込み
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $studentId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }
}

