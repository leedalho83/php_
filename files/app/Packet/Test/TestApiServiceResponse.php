<?php

namespace App\Packet\Test;

use App\Packet\BaseResponse;

// 1. Response Packet 은 항상 BaseResponse 를 상속합니다. ( 2번으로 가시기 전에 BaseResponse 내부 한번 다녀오세요 )
class TestApiServiceResponse extends BaseResponse
{
    // 2. 호출한 API 의 Response 에 담을 데이터를 멤버 변수로 가지고 갑니다.
    public array $localTableList;

    // 3. 인스턴스 생성은 언제나 같은 방식으로 일관화시킴.
    public static function getInstance(): TestApiServiceResponse
    {
        return new TestApiServiceResponse();
    }

    // 4. 생성자에서 멤버 변수를 초기화 합니다.
    public function __construct()
    {
        parent::__construct();
        $this->localTableList = array();
    }
}
