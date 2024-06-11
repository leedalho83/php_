<?php

namespace App\Packet;

use App\Define\ResponseDefine;

// 1. 모든 Response 는 이 클래스를 상속받아, 여기를 수정하는것만으로 모든 API 에 적용될 수 있는 기반을 마련합니다.
class BaseResponse
{
    // 2. 처리 내역에 대한 결과값으로 사용할 멤버 변수이며, 현재는 이것말고 사용할께 없어서 이것만 있음!
    public int $ret;

    // 3. 생성자에서 기본값은 성공값으로 !
    public function __construct()
    {
        $this->ret = ResponseDefine::OK;
    }
}
