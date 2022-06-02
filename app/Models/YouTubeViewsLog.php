<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $yvl_no
 * @property int    $yvl_yul_no
 * @property int    $yvl_views
 * @property string $yvl_registDate
 */
class YouTubeViewsLog extends Model
{
    # db connection 정의 (기본값 default 연결 값)
    # protected $connection = '';

    # table 정의
    protected $table = 'youtube_views_log';

    # primaryKey 정의
    protected $primaryKey = 'yvl_no';

    # primary key Type
    protected $keyType = 'int';

    # auto incrementing 사용 여부
    public $incrementing = true;

    # Timestamp 사용 여부
    public $timestamps = false;

    # CREATED Date Column
    const CREATED_AT = 'yvl_registDate';

    # Update Date Column
    # const UPDATED_AT = '';

    protected int    $yvl_no;
    protected int    $yvl_yul_no;
    protected int    $yvl_views;
    protected string $yvl_registDate;
}
