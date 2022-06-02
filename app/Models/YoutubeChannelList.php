<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $ycl_channel
 * @property string $ycl_registDate
 * @property string $ycl_channelName
 * @property string $ycl_channelGroupName
 */
class YoutubeChannelList extends Model
{
    # db connection 정의 (기본값 default 연결 값)
    # protected $connection = '';

    # table 정의
    protected $table = 'youtube_channel_list';

    # primaryKey 정의
    protected $primaryKey = 'ycl_channel';

    # primary key Type
    protected $keyType = 'string';

    # auto incrementing 사용 여부
    public $incrementing = false;

    # Timestamp 사용 여부
    public $timestamps = false;

    # CREATED Date Column
    const CREATED_AT = 'ycl_registDate';

    # Update Date Column
    # const UPDATED_AT = '';

    protected string $ycl_channel;
    protected string $ycl_registDate;
    protected string $ycl_channelName;
    protected string $ycl_channelGroupName;
}
