<?php

namespace App\Services;

use App\Define\ResponseDefine;
use App\Monitor\MonitorService;
use App\Packet\Test\TestApiServiceResponse;
use App\Repositories\TestRepositories\LocalTableRepository;
use Exception;
use Illuminate\Http\Request;

class TestApiService
{
    // 1. 멤버 변수로 Response Packet을 가지고 있습니다.
    public TestApiServiceResponse $resp;

    // 2. TestApiService를 new로 만들어도 되지만 인스턴스를 생성하는 방식으로 일관화 합니다.
    public static function getInstance(): TestApiService
    {
        return new TestApiService();
    }

    public function __construct()
    {
        // 3. 생성자에서 Response Packet의 인스턴스를 생성합니다.
        $this->resp = TestApiServiceResponse::getInstance();
    }

    public function testProcess(Request $request): void
    {
        try {
            // 파라미터 체크
            // 파라미터는 Validate 같은 라이브러리를 사용하지 않고 상황에 맞게 핸들링하기 위해 하나씩 직접 체크
            if($request->get('id') == null) {
                $this->resp->ret = ResponseDefine::EMPTY_REQUEST_PARAMETER;
                return;
            }

            // idx : 1 의 데이터만 가져오도록 예제 구성해둠
            // 4. Model은 PHP 인터프리터 방식으로 인해 실제 사용하는 타이밍에 호출함, 다른 빌드형 언어의 경우 멤버로 가지고 있고, 생성자에서 호출.
            $localTableRepository = LocalTableRepository::getInstance();

            // 5. Model 함수를 호출하여 DB 처리 후 리턴을 받아 결과값 체크
            $this->resp->localTableList = $localTableRepository->selectOneLocalTableByIdx(1);

            // 6. DB 결과값 유무에 따른 흐름 처리
            if(count($this->resp->localTableList) <= 0) {
                $this->resp->ret = ResponseDefine::EMPTY_DATA;

                $monitorService = MonitorService::getInstance();
                $monitorService->updateErrorLog($monitorService::CONST_CHANNEL_TYPE_NEW_XX_LAB_ETC, 'Unique Function Key String',
                    array('make message' => 'this is test string', 'seconde message' => 'second test string'));
                return;
            }
        } catch(Exception $e) {
            // 만약 오류가 터졌다면 내역을 남긴다.
            // 코드 오류는 try 내부에서 처리하며, catch로 잡히는 오류는 시스템 오류만 감지되도록 개발 필수.
            $monitorService = MonitorService::getInstance();
            $monitorService->updateErrorLog($monitorService::CONST_CHANNEL_TYPE_NEW_XX_LAB_ETC,
                get_class($this), array('exception message' => $e->getMessage(), 'exception code' => $e->getCode()));
        } finally {
            $empty = '';
        }
    }
}
