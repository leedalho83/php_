<?php

namespace App\Define;

/**
 * ex) define
 *
 * define 을 사용하는 방법은 PHP 에서 지원해주는 방법도 여러가지 이지만 ( define('', '') )
 * 여기서는 Class 내부에서 Const 로 사용합니다.
 * 어찌보면 만든사람만 편한 방법일 수 있습니다.
 * 컴파일 로딩타임을 고려해서 더 나은 방법이 있다면 얼마든지 변경 가능합니다.

 *
 * Define Class 이름은 파스칼 형식으로 갑니다. MACRO_CASE로 가려고 하다가 Class 라서 파스칼로 했음.
 * define 변수이름은 MACRO_CASE 를 따라갑니다.
 * 이는 영어권에서 사용하는 강조문 같은 문화가 녹아들어있는 걸로 기억하는데 요즘도 그런지는 모르겠음.
 * 그래서 초기에 디파인을 표기하던 방식을 그대로 사용함.
 * 혹시 누가 역사를 알면 코멘트 추가좀
 */

class TestDefine
{
    const TEST_DEFINE_OK    = 1;
    const TEST_DEFINE_FAIL  = 2;
    const TEST_DEFINE_ERROR = 3;
}
