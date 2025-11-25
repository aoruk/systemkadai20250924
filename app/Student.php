<?php
// 20251124
namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /**
     * テーブル名
     */
    protected $table = 'students';

    /**
     * 複数代入可能な属性
     */
    protected $fillable = [
        'grade',
        'name',
        'address',
        'photo',
        'comment',
    ];

    /**
     * キャストする属性
     */
    protected $casts = [
        'grade' => 'integer',
    ];

    /**
     * リレーション: 学生に紐づく成績データ
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * アクセサ: 顔写真のフルURL取得
     * 
     * @return string|null
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return null;
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
     * スコープ: 名前で検索
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchByName($query, $name)
    {
        return $query->where('name', 'like', "%{$name}%");
    }

    /**
     * スコープ: 住所で検索
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $address
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchByAddress($query, $address)
    {
        return $query->where('address', 'like', "%{$address}%");
    }
}
