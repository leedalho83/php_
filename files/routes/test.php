<?php

use App\Http\Controllers\TestController\TestController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('www/pages/main');
});

Route::get('/en',function(){
    App::setlocale('en');
    return view('www/pages/main');
});
Route::get('/jp',function(){
    App::setlocale('ja');
    return view('www/pages/main');
});

// case 1. 그룹 처리
Route::group(['middleware' => ['setLocale']], function() {
    Route::get('/testApi1.xx', [TestController::class, 'testApi1']);
    Route::get('/testDefine.xx', [TestController::class, 'testDefine']);
});

// case 2. 단일 처리
Route::get('/testApi1.xx', [TestController::class, 'testApi1']);
Route::get('/testDefine.xx', [TestController::class, 'testDefine']);
Route::get('/testApiClass.xx', [TestController::class, 'testApiClass']);

// 특정 호출에만 미들웨어 연결
//Route::post('/testApiMiddleware.xx', [TestController::class, 'testMiddleware'])->middleware('setLocale')->name('testMiddleware');


