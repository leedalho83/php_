<?php

namespace App\Http\Middleware;

use App\Define\LocalizationDefine;
use Closure;
use Illuminate\Http\Request;

class Localization
{
    // 콘텐츠별로 컨트롤러 호출 전, 선행 처리해야 할 내용이 있을 경우 Route와 연동하여 미들웨어로 처리 함.
    public function handle(Request $request, Closure $next)
    {
        $segment = $request->segment(1);
        $language = LocalizationDefine::convertLanguageCode($segment);
        app()->setLocale($language);

        $segCookie = match ($segment) {
            'jp' => cookie('segCookie', 'jp'),
            'en' => cookie('segCookie', 'en'),
            default => cookie('segCookie', ''),
        };

        return $next($request)->withCookie($segCookie);
    }
}
