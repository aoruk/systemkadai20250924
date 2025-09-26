<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('grade');
            $table->string('name');
            $table->string('address');
            $table->string('img_path')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}

/* 20250924
 $table->integer('grade');
 データ型: INTEGER（整数）
 用途: 学年（1年生、2年生、3年生など）を数字で格納

 $table->string('name');
 データ型: VARCHAR(255)（文字列、最大255文字）
 用途: 学生の名前を格納

 $table->string('address');
 データ型: VARCHAR(255)
 用途: 学生の住所を格納

 $table->string('img_path')->nullable();
 データ型: VARCHAR(255) NULL
 ->nullable(): このカラムはNULL値（空）でもOK
 用途: 学生の写真ファイルのパスを格納

 $table->text('comment')->nullable();
 データ型: TEXT NULL（長い文字列用）
 text(): string()より長い文字列を格納可能
 用途: 学生に関するコメントや備考を格納

 データ型の違い
 integer() SQL:INT 整数 最大文字数:-2,147,483,648 ～ 2,147,483,647
 string() SQL:VARCHAR(255) 短い文字列 最大文字数:255文字
 text() SQL:TEXT 長い文字列 最大文字数:約65,000文字

 nullable()について
 なし: そのカラムは必須入力（NOT NULL）
 ->nullable(): そのカラムは空でもOK（NULL許可）
*/