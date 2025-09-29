<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| 学生成績管理システムのルーティング設定
| 画面遷移図に基づいてルートを定義しています
*/

/* 20250927
 基本的な書き方
 Route::HTTPメソッド('URL', 'コントローラー@メソッド')->name('名前');

 Route::get('/url', 'Controller@method');     // GET リクエスト（表示）
 Route::post('/url', 'Controller@method');    // POST リクエスト（送信）
 Route::put('/url', 'Controller@method');     // PUT リクエスト（更新）
 Route::delete('/url', 'Controller@method');  // DELETE リクエスト（削除）
 Route::patch('/url', 'Controller@method');   // PATCH リクエスト（部分更新）
*/

// ホーム画面（管理ユーザーログイン画面）20250926 
Route::get('/', function () {
    return view('welcome');
})->name('home');
/* 20250927
 ・Route::get() : GETメソッドでアクセスされた時の処理
 ・'/' : URL（この場合はルートURL）
 ・function () { ... } : 無名関数（クロージャ）で直接ビューを返す
 ・return view('welcome') : resources/views/welcome.blade.phpを表示
*/

// 認証関連のルート 20250927 
// ログイン画面を表示（GET）
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
/* 20250927
 ルート名の付け方
 ->name('login') : このルートに「login」という名前を付ける
 メリット: URLが変更されても、ビューファイルでroute('login')と書けば自動で正しいURLが生成される
*/

// ログイン処理を実行（POST）
Route::post('/login', 'AuthController@login')->name('login.post');
/* 20250927
 ・HTTPメソッド: POST - データを送信するため
 ・URL: /login
 ・処理: AuthControllerのloginメソッドを実行
 ・ルート名: login.post

 実際の処理の流れ
 1.ログイン画面でフォーム送信
 2.このルートが呼ばれる
 3.AuthControllerのloginメソッドが実行される
*/

// ログアウト処理を実行（POST）
Route::post('/logout', 'AuthController@logout')->name('logout');
/* 20250927
 ・HTTPメソッド: POST - ログアウト処理（状態変更）のため
 ・URL: /logout
 ・処理: AuthControllerのloginメソッドを実行
 ・ルート名: logout

 実際の処理の流れ
 1.ログアウトボタンをクリック
 2.このルートが呼ばれる
 3.AuthControllerのloginメソッドが実行される
*/

// 管理ユーザー新規登録　20250927
// 登録画面を表示（GET）
Route::get('/admin/register', function () {
    return view('admin.register');
})->name('admin.register');
/* 20250927
 ・HTTPメソッド: GET - 画面を表示
 ・URL: /admin/register
 ・処理: 無名関数（クロージャ）で直接ビューを返す
 ・return view('admin.register'): resources/views/admin/register.blade.phpを表示
 ・ルート名: admin.register

 実際の処理の流れ
 1.登録画面を表示 http://localhost/admin/register にアクセス
 2.このルートが呼ばれる
 3.表示されるファイル:resources/views/admin/register.blade.php
*/

// 登録処理を実行（POST）
Route::post('/admin/register', 'AdminController@register')->name('admin.register.post');
/* 20250927
 ・HTTPメソッド: POST - フォームデータを送信・処理
 ・URL: /admin/register （GETと同じURLだがメソッドが違う）
 ・処理: AdminControllerのregisterメソッドを実行
 ・ルート名: admin.register.post

 実際の処理の流れ
 1.登録フォームを送信
 2.このルートが呼ばれる
 3.AdminControllerのregisterメソッドが実行される
*/

// ログイン後のメイン機能（認証が必要なルート）20250928
Route::middleware(['auth'])->group(function () {
 /* 20250928
  middlewareとは？
  ミドルウェア = リクエストとレスポンスの間に挟まる処理
  ユーザーのリクエスト 　　　　　例：映画館で映画を見る
        ↓　　　　　　　　　　　　　　　　↓　
    ミドルウェア（認証チェック）　　入場券チェック（ミドルウェア）
        ↓　　　　　　　　　　　　　　　　↓
    コントローラー　　　　　　　　　映画鑑賞（本来の処理）
        ↓　　　　　　　　　　　　
    レスポンス（画面表示）　　　　　入場券がないと映画は見れない → ログインしてないとページは見れない
    
    Route::middleware(['auth'])->group(function () {
     // ここに書いたルートは全て認証が必要
     });
     ・middleware(['auth']) : 認証ミドルウェアを適用
     ・group(function () { ... }) : 複数のルートをまとめる
     ・['auth'] : 配列で複数のミドルウェアを指定可能
 */   

    // メニュー画面　20250928
    Route::get('/menu', function () {
        return view('menu.index');
    })->name('menu');
 /* 20250928
  ・場所: 認証グループの中 → ログインが必要
  ・HTTPメソッド: GET（画面表示）
  ・URL: /menu
  ・処理: resources/views/menu/index.blade.php を表示
  ・ルート名: menu
   実際の動作例
   ケース1: ログインしていない状態でアクセス
  【ユーザーの操作】
     http://localhost/menu にアクセス

  【Laravelの処理】
     1. Route::middleware(['auth']) をチェック
     2. Auth::check() → false（ログインしていない）
     3. 自動でログイン画面にリダイレクト: /login
     4. ログイン画面が表示される

  【ブラウザのURL変化】
     http://localhost/menu
        ↓（自動リダイレクト）
     http://localhost/login

   ケース2: ログインしている状態でアクセス
  【ユーザーの操作】
     http://localhost/menu にアクセス

  【Laravelの処理】
     1. Route::middleware(['auth']) をチェック
     2. Auth::check() → true（ログイン済み）
     3. return view('menu.index') を実行
     4. メニュー画面が表示される

  【ブラウザのURL変化】
     resources/views/menu/index.blade.php　　
 */
    // 学生管理関連 20250928
    Route::prefix('students')->group(function () {
 /* 20250928
  Route::prefix()とは？
  Route::prefix('students')->group(function () {
  // ここに書いたルートは全て /students/ から始まる
  });　
 */        
        // 学生表示画面 20250928
        Route::get('/', 'StudentController@index')->name('students.index');
 /* 20250928
 ・HTTPメソッド: GET - 画面を表示
 ・URL: '/' (相対パス)+ '/students/'(prefix)
 ・処理: StudentControllerのindexを実行
 ・return view('students.index', compact('students')): resources/views/students/index.blade.phpを表示
 ・ルート名: students.index

 実際の処理の流れ
 1.ユーザーが /students/ にアクセス
 2.Laravel が StudentController を探す(ファイル場所: app/Http/Controllers/StudentController.php)
 3.indexメソッドを実行し、学生一覧データを取得
 4.表示されるファイル:resources/views/students/index.blade.php
 */   
        // 学生登録画面 20250928
        // 登録画面を表示（GET）
        Route::get('/create', 'StudentController@create')->name('students.create');
 /* 20250928
 ・HTTPメソッド: GET - 学生登録画面を表示
 ・URL: '/create' (相対URL)+ '/students/create'(完全URL)
 ・処理: StudentControllerのcreateを実行
 ・return view('students.create'): resources/views/students/create.blade.phpを表示
 ・ルート名: students.create

 実際の処理の流れ
 　新規登録フォームを表示するだけ
 */
        // 登録処理を実行（POST）
        Route::post('/store', 'StudentController@store')->name('students.store');
 /* 20250928
 ・HTTPメソッド: POST - 学生登録処理を実行
 ・URL: '/store' (相対パス)+ '/students/store'(完全URL)
 ・処理: StudentControllerのstoreを実行
 ・ルート名: students.store (フォームのaction属性で使用)

 バリデーションとは？
 　バリデーション = 入力値チェック
 　ユーザーが入力したデータが正しいかどうかを確認する処理

 実際の処理の流れ
 成功パターン
 1.GET /students/create
   → 登録フォーム表示
 2.ユーザーがフォーム入力・送信
   → POST /students/store
 3.バリデーション成功
   → データベースに保存
   → redirect()->route('students.index') 
   → GET /students/  
   → 一覧画面表示（成功メッセージ付き）

 失敗パターン
 1.GET /students/create
   → 登録フォーム表示
 2.ユーザーがフォーム入力・送信（不正な値）
   → POST /students/store
 3.バリデーション失敗
   → 自動で GET /students/create にリダイレクト
   → 登録フォーム再表示（エラーメッセージ＋入力値保持）
 */       
        // 学生詳細表示画面 20250928
        Route::get('/{id}', 'StudentController@show')->name('students.show');
 /* 20250928
 ・HTTPメソッド: GET - 画面を表示
 ・URL: '/{id}' (prefix内での相対パス)+ '/students/123'(実際のURL（123は学生ID))
 ・パラメーター: {id} URLから学生IDを受け取る
 ・処理: StudentController@showの詳細表示メソッドを実行
 ・return view('students.show', compact('student')): resources/views/students/show.blade.phpを表示
 ・ルート名: students.show

 {id} パラメーターとは？ {id} = 可変部分

 Route::get('/{id}', ...);

 波括弧 {} で囲むと、その部分が変数になる
 URLの一部がコントローラーに渡される
 異なる学生の情報を同じルートで表示できる

 // 実際のアクセス例:
 /students/1    → {id} = 1
 /students/123  → {id} = 123
 /students/999  → {id} = 999

 実際の処理の流れ
 STEP 1: ユーザーが詳細ボタンクリック
 一覧画面のリンク: <a href="{{ route('students.show', 5) }}">

 STEP 2: Laravelがルートを解決
 route('students.show', 5) → /students/5

 STEP 3: ブラウザがアクセス
 GET /students/5

 STEP 4: ルートがマッチ
 Route::get('/{id}', 'StudentController@show')
     ↓
 {id} = 5

 STEP 5: コントローラー実行
 StudentController@show(5)
     ↓
 Student::findOrFail(5)
     ↓
 $student = ID=5の学生データ

 STEP 6: ビュー表示
 return view('students.show', compact('student'))
     ↓
 詳細画面表示 resources/views/students/show.blade.php
 */
        // 学生編集画面 20250929
        // 編集画面を表示（GET）
        Route::get('/{id}/edit', 'StudentController@edit')->name('students.edit');
/* 20250929
 ・HTTPメソッド: GET - 学生編集画面を表示
 ・URL: '/{id}/edit' (prefix内での相対パス)+ '/students/123/edit'(実際のURL)
 ・パラメーター: {id} URLから編集する学生IDを受け取る
 ・処理: StudentController@editの編集画面表示メソッドを実行
 ・return view('students.edit', compact('student')): resources/views/students/edit.blade.phpを表示
 ・ルート名: students.edit

 実際の処理の流れ
 STEP 1: URLからIDを取得
 /students/123/edit → $id = 123

 STEP 2: データベースから学生情報取得
 Student::findOrFail(123)
     ↓
 $student = {
    id: 123,
    student_number: "2024123",
    name: "田中太郎",
    grade: 1
 }

 STEP 3: 編集画面に既存データを渡す
 return view('students.edit', compact('student'))
      ↓
 編集フォームに現在の値が入った状態で表示
*/
        // 編集内容を更新（PUT）
        Route::put('/{id}', 'StudentController@update')->name('students.update');
/* 20250929
 ・HTTPメソッド: PUT - データ更新専用メソッド(全体更新)
 ・URL: '/{id}' (prefix内での相対パス)+ '/students/123'(実際のURL)
 ・処理: StudentController@updateの更新処理メソッドを実行
 ・ルート名: students.update

 実際の処理の流れ
 1.【編集画面】
    URL: /students/123/edit
    学生編集 例: 名前[田中太郎]→名前[田中次郎]に更新
    PUT /students/123
 2.【更新処理実行】
    StudentController@update
    - バリデーション ✅
    - DB更新 ✅
    - リダイレクト準備
         ↓
 4.【詳細画面】
    URL: /students/123
    学生詳細 名前[田中次郎]に更新済み
*/
        // 学生削除 20250929
        Route::delete('/{id}', 'StudentController@destroy')->name('students.destroy');
/* 20250929
  ・HTTPメソッド: DELETE - データを削除
  ・URL: '/{id}' (prefix内での相対パス)+ '/students/{id}'(実際のURL)
  ・処理: StudentController@destroyの削除処理メソッドを実行
 ・ルート名: students.destroy

   実際の動作例
   [ブラウザ]                [Laravel]                [データベース]
    |                        |                          |
    | 1. 削除ボタンクリック     |                          |
    |----------------------->|                          |
    | POST /students/{id}    |                          |
    | _method=DELETE         |                          |
    |                        |                          |
    |　　　　　　　　　　  2. ルート判定                     |
    |                    web.php                        |
    |                  DELETE /{id}                     |
    |                        |                          |
    | 　　　　　　　　　　 3. コントローラー呼び出し           |
    |                    StudentController              |
    |                    destroy({id})                  |
    |                        |                          |
    |                        | 4. データ削除　　　　　　　  |
    |                        |------------------------->|
    |                        |  DELETE FROM students    |
    |                        |  WHERE id = {id}         |
    |                        |<-------------------------|
    |                        | 5. 削除完了       　　     |
    |                        |                          |
    |   6. リダイレクト        |                          |
    |<-----------------------|                          |
    |   GET /students        |                          |
    |                        |                          |
    |   7. 一覧画面表示        |                          |
    |<-----------------------|                          |
    |  「削除しました」      　 |                          |
*/

    });
});
