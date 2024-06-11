<?php

namespace App\Define;

/**
 * 이 값을 클라이언트 (웹페이지 또는 제품) 에서 받아볼 최종 오류 값 입니다.
 * 이전에 제품에서 사용중인 값이 있으면 그값은 그대로 사용해야 합니다.
 * 신규 플랫폼의 경우 웹페이지를 백엔드셀에서 개발하기 때문에 내부적으로만 맞춰서 사용하면 됩니다.
 * 내부적으로 맞추는 방법? 오류값을 추가하기 전에 항상 여기 클래스를 확인해보면 됨
 * 하다보니 ResponseCode가 몇백개씩 늘어날듯하면 컨텐츠 별로 ResponseDefine 파일을 분류시켜버리면됨
 */
class ResponseDefine
{
    // 100 이하는 시스템 오류 값으로 사용
    const OK                        = 1;    // 언제나 1은 성공값

    const API_ERROR                 = -1;   // API 처리 중 오류
    const INVALID_REQUEST_PARAMETER = -2;   // request parameter 오류 : 잘못된 값
    const AWS_NETWORK_ERROR         = -3;   // s3 연결 오류
    const AWS_FILE_ERROR            = -4;  // s3에서 가져온 파일 내용이 잘못됨
    const DB_ERROR                  = -10;  // DB 커넥션 오류
    const EMPTY_REQUEST_PARAMETER   = -11;  // request parameter 오류 : 값이 비었음
    const EMPTY_DATA                = -12;  // 데이터가 없음
}
