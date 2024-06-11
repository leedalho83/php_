<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/home';

    public function boot(): void
    {
        // 라우트 : 서비스별 파일 분할
        $this->routes(function () {
            $segment = request()->segment(1);
            switch($segment) {
                case 'test':
                    Route::prefix('test')->namespace($this->namespace)->group(base_path('routes/test.php'));
                    break;
                case 'test_api':
                    Route::prefix('test2')->namespace($this->namespace)->middleware('test2')->group(base_path('routes/test.php'));
                    break;
                case 'kr':
                    // ..
                case 'jp':
                    //..
            }
        });
    }
}
