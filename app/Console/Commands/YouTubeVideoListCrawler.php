<?php

namespace App\Console\Commands;

use App\Crawler\YouTube;
use App\Models\YoutubeChannelList;
use App\Models\YouTubeUrlList;
use App\Telegram;
use Illuminate\Console\Command;

class YouTubeVideoListCrawler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'YouTubeVideoListCrawler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '유튜브 채널들 비디오 리스트 가져오기';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $youTube = new YouTube();
        $youTube->clientRun();

        /** @var YoutubeChannelList $channelRow */
        foreach (YoutubeChannelList::all() as $channelRow) {
            $channelUrl  = $channelRow->ycl_channel;
            $channelName = $channelRow->ycl_channelName;

            foreach ($youTube->getVideoList($channelUrl) as $videoRow) {
                if ($videoRow['videoTitle'] && $videoRow['address'] && !YouTubeUrlList::findVideo($channelName, YouTube::URL . $videoRow['address'])) {
                    YouTubeUrlList::create($channelName, YouTube::URL . $videoRow['address'], $videoRow['videoTitle']);
                    Telegram::allUserSendMsg(YouTube::URL . $videoRow['address']);
                }
            }
        }
    }
}
