<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property int    $yul_no
 * @property string $yul_ycl_channelName
 * @property string $yul_url
 * @property string $yul_title
 * @property string $yul_registDate
 * @property string $yul_deleteDate
 */
class YouTubeUrlList extends Model
{
    # db connection 정의 (기본값 default 연결 값)
    # protected $connection = '';

    # table 정의
    protected $table = 'youtube_url_list';

    # primaryKey 정의
    protected $primaryKey = 'yul_no';

    # primary key Type
    protected $keyType = 'int';

    # auto incrementing 사용 여부
    public $incrementing = true;

    # Timestamp 사용 여부
    public $timestamps = false;

    # CREATED Date Column
    const CREATED_AT = 'yul_registDate';

    # Update Date Column
    # const UPDATED_AT = '';

    protected int    $yul_no;
    protected string $yul_ycl_channelName;
    protected string $yul_url;
    protected string $yul_title;
    protected string $yul_registDate;
    protected string $yul_deleteDate;

    /**
     * 해당 영상 DB 조회
     *
     * @param string $channelName
     * @param string $url
     * @return bool
     */
    public static function findVideo(string $channelName, string $url): bool
    {
        return !!DB::table('youtube_url_list')->where('yul_ycl_channelName', $channelName)->where('yul_url', $url)->first();
    }

    /**
     * @param string $channel
     * @param string $url
     * @param string $title
     * @return void
     */
    public static function create(string $channel, string $url, string $title): void
    {
        DB::table('youtube_url_list')->insert([
            'yul_ycl_channelName' => $channel,
            'yul_title'           => $title,
            'yul_url'             => $url,
            'yul_registDate'      => date('Y-m-d H:i:s'),
        ]);
    }
}
