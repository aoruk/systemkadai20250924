<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_grades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('student_id');
            $table->integer('grade');
            $table->string('term');
            $table->integer('japanese')->nullable();
            $table->integer('math')->nullable();
            $table->integer('science')->nullable();
            $table->integer('social_studies')->nullable();
            $table->integer('music')->nullable();
            $table->integer('home_economics')->nullable();
            $table->integer('english')->nullable();
            $table->integer('art')->nullable();
            $table->integer('health_and_physical_education')->nullable();
            $table->timestamps();
            
            // 外部キー制約
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_grades');
    }
}

/* 20250924
 $table->bigIncrements('id');
 データ型: BIGINT UNSIGNED AUTO_INCREMENT
 特徴:
 bigIncrements: 大きな整数で自動増分
 自動増分: 1, 2, 3, 4... と自動的に番号が振られる
 主キー: テーブル内で各レコードを一意に識別
 UNSIGNED: 負の数は使わない（0以上の数のみ）

 $table->unsignedBigInteger('student_id');
 データ型: BIGINT UNSIGNED
 特徴:
 unsignedBigInteger: 符号なし大整数（正の数のみ）
 外部キー: 他のテーブル（students）のidを参照
 リレーション: studentsテーブルのどの学生の成績かを示す
 用途: studentsテーブルのid（1, 2, 3...）を格納

 なぜbigIncrementsとunsignedBigIntegerを使う？
 データ型の統一: 両方ともBIGINT UNSIGNEDで統一
 外部キー制約: 参照先（students.id）と参照元（school_grades.student_id）のデータ型が同じである必要がある
 大きなデータ対応: 将来的に大量のデータにも対応可能

 外部キー制約
 $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');

 これで「student_idはstudentsテーブルのidを参照する」という関係を明示的に定義
*/