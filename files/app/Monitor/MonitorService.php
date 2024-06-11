<?php

namespace App\Monitor;

use App\Repositories\Monitor\MonitorRepository;

class MonitorService
{
    // 모니터 서비스의 경우 독립 클래스이기에 디파인 흐름도 따라가지 않고 전부 멤버로 관리합니다.
    // 다른 프로젝트에서도 그대로 떼어다 쓸 수 있도록하기 위함.
    const CONST_CHANNEL_TYPE_NEW_XX_LAB_ETC = 'newEtc';
    const CONST_NEW_XX_LAB_CHANNEL_ID = '';

    //private MonitorRepository $monitorRepository;

    public static function getInstance(): MonitorService
    {
        return new MonitorService();
    }

    public function __construct()
    {
        //$this->monitorRepository = MonitorRepository::getInstance();
    }

    public function updateErrorLog($channelTypeName, $functionName, $info = array()): void
    {
        $errorInfo = array();
        $errorInfo['error_function'] = $functionName;
        $errorInfo['error_channel'] = $channelTypeName;
        $errorInfo['error_info'] = json_encode($info);

        $ch = curl_init();

        // 생략. 현재의 프로젝트에서는 DB에 저장하는 별도의 서버가 존재하기 때문에, 해당 서버 연동은 제외함

        curl_close($ch);
    }
}
