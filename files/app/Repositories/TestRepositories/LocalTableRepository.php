<?php

namespace App\Repositories\TestRepositories;

use App\Define\DatabaseNameDefine;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;

/**
 * 1. DB Name + Repository 네이밍으로 Repository 를 생성합니다.
 * 이때 BaseRepository 를 상속받습니다.
 */
class LocalTableRepository extends BaseRepository
{
    // 2. 인스턴스 생성용. 프로젝트의 모든 인스턴스 생성은 아래와 같이 getInstance 를 통해 new를 생성하는 흐름
    public static function getInstance(): LocalTableRepository
    {
        return new LocalTableRepository();
    }

    // 3. 생성자에서 테이블 이름을 담아줍니다.
    public function __construct()
    {
        parent::__construct('local_table');
    }

    // 4. 쿼리 함수에서 사용하게 될 테이블이름은 get 으로 받아서 사용합니다.
    // 여기까지가 Repository 를 생성할때 기본적으로 들어가는 코드입니다.
    public function getTableName(): string
    {
        return parent::getTableName();
    }

    // 5. 이후 부터는 필요한 쿼리를 생성합니다.
    // 이때, 함수 이름은 해당 쿼리가 어떤 쿼리인지 확실히 인지할수 있도록 네이밍을 지정합니다.
    // 아래 함수는 local_table 에서 1개의 데이터만 idx 로 select 하는 내용을 지정해둔 함수입니다.
    // 네이밍 => crud + 단일? 복수? + table Name + where 기준이 무엇?
    // 참고) 네이밍 케이스가 너무 다양하다, 남이봐도 어떤 쿼리인지 알아볼 수 있는 네이밍을 잘 정하는걸로 하고 애매하면 그냥 함수하나 더 만들어서 사용
    public function selectOneLocalTableByIdx($idx): array
    {
        try {
            // 6. 1개만 가져오더라도 무조건 get() -> toArray() 형태를 맞춰서 배열로 리턴하도록 합니다.
            // 받아쓰는곳에서 항상 같은 형태로 받을 수 있도록 맞춰둡니다.
            return DB::connection(DatabaseNameDefine::getMasterDBName())  // 흐름상 자연스럽게 보라고 이 부분 참고사항 맨 밑에 주석으로 넣어놨음
                ->table(parent::getTableName())
                ->select('*')
                ->where('idx', '=', $idx)
                ->get()
                ->toArray();
        } catch(Exception $e) {
            parent::updateErrorInfo($this->monitorService::CONST_CHANNEL_TYPE_NEW_XX_LAB_ETC,
                get_class($this), array('exception message' => $e->getMessage(), 'exception code' => $e->getCode()));

            // 6. 오류면 빈배열 리턴
            return [];
        }
    }
}

/**
 * eloquent 호출 순서
 * DB:connection 함수에 들어가는 파라미터값은  /config/database.php 파일의 connections 배열의 key 이름입니다.
 * 해당 배열의 정보로 db connection 을 생성할때 필요한 커넥션 정보와 옵션을 참고하게 됩니다.
 * connections 배열의 value 값들은 env 를 호출하도록 되어 있고, env의 key 값을 참고하여 value가 셋팅됩니다.
 *
 * env 참고사항
 * laravel 에서는 환경에 따른 설정값을 분류하는 방법을 .env 를 통해 지원하고 있습니다.
 * .env 가 기준파일이며, 이 파일의 상단의 APP_ENV 값에 따라 원하는 env 파일을 참고하도록 할 수 있습니다.
 *
 * 사용 방법
 * 신규곰플랫폼에서는 로컬 환경과 라이브 환경을 분리합니다.
 * 환경에 따른 env 값을 사용하고 싶을 경우!
 * .env 파일의 APP_ENV 값을 local로 입력합니다.
 * .env.local 파일을 생성합니다.
 * .env.local 파일의 APP_ENV 값을 local로 입력합니다.
 * 파워쉘에서 php artisan config:clear 를 통해 env를 다시 읽어 오도록 합니다.
 * php artisan serve 를 통해 서비스를 run 하고 호출 테스트를 해보면 다른 env값을 참고한다는것을 확인할 수 있습니다.
 *
 * 곰TV에서는 이렇게 분류하지 않고 실제 서비스 머신에 환경 변수를 지정하고 getEnv 함수를 통해 지정된 값을 체크하여 처리하였습니다. TMI..
 */
