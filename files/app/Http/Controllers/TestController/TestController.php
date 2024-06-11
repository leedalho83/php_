<?php

namespace App\Http\Controllers\TestController;
use App\Http\Controllers\Controller;
use App\Services\TestApiService;
use Illuminate\Http\Request;

class TestController extends Controller
{
    // 함수 표기는 psr을 따라 중괄호는 BSD를 따라 가지만 이후 함수 내부에서는 K&R을 사용한다.
    // 그리고 대부분 psr 보다는 취향을 더 많이 탄..

    // 컨트롤러 코드는 비즈니스 코드를 API와 1:1로 관리하는 형태로 합니다.
    // 컨트롤러 코드가 길어질 경우 유지보수 및 가독성이 떨어지기 때문.
    public function testApi1(Request $request)
    {
        // 1. api 의 service class 인스턴스를 생성합니다.
        $testApiService = TestApiService::getInstance();

        // 2. 비지니스 함수를 호출하며 이때 request 를 파라미터로 넘깁니다.
        $testApiService->testProcess($request);

        // 3. 처리가 끝난다음 return 으로 마무리
        return response()->json([
            'response' => $testApiService->resp
        ]);
    }
}
