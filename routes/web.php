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


