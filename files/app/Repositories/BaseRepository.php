<?php

namespace App\Repositories;

use App\Monitor\MonitorService;

class BaseRepository
{

    // 1. BaseRepository 테이블 이름과 오류 알림을 위한 MonitorService 를 가지고 있습니다.
    protected string $tableName;
    protected MonitorService $monitorService;

    protected function __construct($tableName)
    {
        // 2. 상속하는 클래스에서 넘긴 테이블 이름을 가지고 있습니다.
        // 테이블 이름은 직접 타이핑 하지 않고, 파라미터로 받아와 get 함수를 통해 사용합니다.
        // php 8.x 부터 string 을 직접 타이밍 하는 방식은 psr convention 에 맞지 않습니다.
        $this->tableName = $tableName;

        // 3. MonitorService 인스턴스를 생성합니다.
        $this->monitorService = MonitorService::getInstance();
    }

    // 4. 테이블 이름 get 함수
    protected function getTableName(): string
    {
        return $this->tableName;
    }

    // 파라미터 1 : 오류 알림을 보낼 팀즈 채널 타입
    // 파라미터 2 :
    //   오류가 발생한 함수 이름 => 팀즈에서 알림 확인 후 코드에서 바로 찾아가기 위함
    //   오류 알림 스케줄러 1분마다 오류 내역을 가져와 팀즈로 알리게 되어 있음
    //   팀즈 웹훅 연동시, 호출 제한이 존재하기 때문에 알림을 줄이기 위해 동일한 오류는 카운트만 증가시켜서 한번만 알리도록 함.
    // 파라미터 3 : try ~ catch 에서 발생한 exception 의 message, code 또는 본인이 추가하고 싶은 오류 내역을 배열로 넘김
    //   DB에 위 배열을 json 으로 저장함. column 은 longText 로 되어 있어 제한은 없지만 짧을수록 좋음.
    protected function updateErrorInfo($channelTypeName, $errorFunc, $info = array()): void
    {
        /*
         * 개발 환경별 분리
        if(env('APP_ENV', 'local') == 'local') {
            return;
        }
        */

        $this->monitorService->updateErrorLog($channelTypeName, $errorFunc, $info);
    }
}