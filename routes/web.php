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

// 認証関連のルート 20251004 
// 直接ログイン画面を表示（GET）
Route::get('/', function () {
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
    // ログアウト処理を実行（POST）20251125 修正
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
         // 学生削除
         Route::delete('/{id}', 'StudentController@destroy')->name('students.destroy');
 /* 20250929
  ・HTTPメソッド: DELETE - データを削除
  ・URL: '/{id}' (prefix内での相対パス)+ '/students/{id}'(実際のURL)
  ・処理: StudentController@destroyの削除処理メソッドを実行
  ・ルート名: students.destroy
  実際の動作例
  [ブラウザ]              [Laravel]                [データベース]
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

         // 検索機能（ここに移動）20251003 20251125 ルート削除
        //  Route::get('/search', 'StudentController@search')->name('students.search');
/* 20250930
  ・HTTPメソッド: GET - 検索結果を表示
  ・URL: '/search' (相対パス) + '/students/' (prefix)
  ・パラメータ: クエリストリング（URLの?以降）で検索条件を受け取る
    - 例: /students/search?keyword=山田 → 「山田」で検索
    - 例: /students/search?keyword=太郎&grade=1 → 複数条件で検索
  ・処理: StudentControllerのsearchを実行
  ・return view('students.index', compact('students')): 検索結果を表示
  ・ルート名: students.search

  実際の処理の流れ
  1. ユーザーが検索フォームにキーワードを入力して送信
  2. ブラウザが GET /students/search?keyword=山田 にアクセス
  3. Laravel が StudentController を探す (ファイル場所: app/Http/Controllers/StudentController.php)
  4. searchメソッドを実行
     - $request->get('keyword'): 検索キーワードを取得
     - Student::where('name', 'like', "%山田%"): あいまい検索を実行
     - SQL実行例: SELECT * FROM students WHERE name LIKE '%山田%'
  5. 表示されるファイル: resources/views/students/index.blade.php
  6. 検索結果の学生一覧が表示される
*/
    });
    // 成績管理関連 20250930
    Route::prefix('grades')->group(function () {
 /* 20250930
  Route::prefix()とは？
  Route::prefix('grades')->group(function () {
  // ここに書いたルートは全て /grades/ から始まる
  });　
 */        
      // 成績追加画面 20251125 修正
      Route::get('/create/{student_id}', 'GradeController@create')->name('grades.create');
/* 20250930
 ・HTTPメソッド: GET - 成績追加画面を表示
 ・URL: '/create/{student_id?}' (相対パス) + '/grades/' (prefix)
 ・パラメータ: {student_id?} - ?付きなので省略可能（オプション）
  - あり: /grades/create/5 → 学生ID=5の成績登録画面
  - なし: /grades/create → 学生選択付き成績登録画面
 ・処理: GradeControllerのcreateを実行
 ・return view('grades.create', ...): resources/views/grades/create.blade.phpを表示
 ・ルート名: grades.create

 実際の処理の流れ
  1. ユーザーが /grades/create または /grades/create/5 にアクセス
  2. Laravel が GradeController を探す (ファイル場所: app/Http/Controllers/GradeController.php)
  3. createメソッドを実行
  - student_idがある場合: 指定された学生の情報を取得
  - student_idがない場合: 全学生リストを取得
  4. 表示されるファイル: resources/views/grades/create.blade.php
*/
      // 成績登録処理 20250930
      Route::post('/store', 'GradeController@store')->name('grades.store');
/* 20250930
 ・HTTPメソッド: POST - 成績登録処理を実行
 ・URL: '/store' (相対パス) + '/grades/' (prefix)
 ・処理: GradeControllerのstoreを実行
 ・フォームから受け取るデータ:
  - student_id: 学生ID
  - subject: 科目名
  - score: 点数
 ・return redirect()->route('students.show', $student_id): 学生詳細画面にリダイレクト
 ・ルート名: grades.store

 実際の処理の流れ
 1. ユーザーが成績登録画面でフォーム送信
 2. ブラウザが POST /grades/store にデータを送信
 3. Laravel が GradeController を探す (ファイル場所: app/Http/Controllers/GradeController.php)
 4. storeメソッドを実行
   - バリデーション: 入力データをチェック
   - Grade::create(): データベースのgradesテーブルに保存
   - SQL実行例: INSERT INTO grades (student_id, subject, score) VALUES (5, '数学', 85)
 5. redirect(): 学生詳細画面 (/students/5) にリダイレクト
 6. 「成績を登録しました」メッセージを表示
*/      
      // 成績編集画面 20250930
      Route::get('/{id}/edit', 'GradeController@edit')->name('grades.edit');
 /* 20250930
 ・HTTPメソッド: GET - 成績編集画面を表示
 ・URL: '/{id}/edit' (相対パス) + '/grades/' (prefix)
 ・パラメーター: {id} URLから編集する学生IDを受け取る
  - 例: /grades/10/edit → 成績ID=10の編集画面
 ・処理: GradeControllerのeditを実行
 ・return view('grades.edit', compact('grade', 'students')): resources/views/grades/edit.blade.phpを表示
 ・ルート名: grades.edit

 実際の処理の流れ
 1. ユーザーが /grades/10/edit にアクセス（編集ボタンをクリック）
 2. Laravel が GradeController を探す (ファイル場所: app/Http/Controllers/GradeController.php)
 3. editメソッドを実行
   - Grade::findOrFail(10): 成績ID=10のデータを取得
   - SQL実行例: SELECT * FROM grades WHERE id = 10
   - Student::all(): 学生リストも取得（学生変更の可能性のため）
 4. 表示されるファイル: resources/views/grades/edit.blade.php
 5. フォームに既存のデータ（科目名、点数など）が表示される
 */      
      // 成績更新処理 20250930
      Route::put('/{id}', 'GradeController@update')->name('grades.update');
 /* 20250930
  ・HTTPメソッド: PUT - データ更新専用メソッド(全体更新)
  ・URL: '/{id}' (相対パス) + '/grades/' (prefix)
  ・パラメータ: {id} - 更新する成績のID（必須）
    - 例: /grades/10 → 成績ID=10を更新
  ・処理: GradeControllerのupdateを実行
  ・フォームから受け取るデータ:
  - student_id: 学生ID
  - subject: 科目名
  - score: 点数
  ・return redirect()->route('students.show', $student_id): 学生詳細画面にリダイレクト
  ・ルート名: grades.update

  実際の処理の流れ
  1. ユーザーが編集画面でフォーム送信
  2. ブラウザが PUT /grades/10 にデータを送信
   - 実際はPOSTメソッドで送信 + @method('PUT')
  3. Laravel が GradeController を探す (ファイル場所: app/Http/Controllers/GradeController.php)
  4. updateメソッドを実行
   - Grade::findOrFail(10): 成績ID=10を取得
   - バリデーション: 入力データをチェック
   - $grade->update(): データベースのgradesテーブルを更新
   - SQL実行例: UPDATE grades SET subject='数学', score=90 WHERE id = 10
  5. redirect(): 学生詳細画面 (/students/5) にリダイレクト
  6. 「成績を更新しました」メッセージを表示
*/      
      // 成績削除 20250930
      Route::delete('/{id}', 'GradeController@destroy')->name('grades.destroy');
/* 20250930
  ・HTTPメソッド: DELETE - データを削除
  ・URL: '/{id}' (相対パス) + '/grades/' (prefix)
  ・パラメータ: {id} - 削除する成績のID（必須）
    - 例: /grades/10 → 成績ID=10を削除
  ・処理: GradeControllerのdestroyを実行
  ・return redirect()->route('students.show', $student_id): 学生詳細画面にリダイレクト
  ・ルート名: grades.destroy

  実際の処理の流れ
  1. ユーザーが削除ボタンをクリック（確認ダイアログ表示）
  2. ブラウザが DELETE /grades/10 にリクエスト送信
     - 実際はPOSTメソッドで送信 + @method('DELETE')
  3. Laravel が GradeController を探す (ファイル場所: app/Http/Controllers/GradeController.php)
  4. destroyメソッドを実行
     - Grade::findOrFail(10): 成績ID=10を取得
     - $grade->delete(): データベースから削除
     - SQL実行例: DELETE FROM grades WHERE id = 10
  5. redirect(): 学生詳細画面 (/students/5) にリダイレクト
  6. 「成績を削除しました」メッセージを表示
*/
  });
 
});
