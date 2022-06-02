<?php

namespace App\Console\Commands;

use App\Crawler\YouTube;
use App\Models\YouTubeUrlList;
use App\Models\YouTubeViewsLog;
use App\Telegram;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class YouTubeVideoViewsCountCrawler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'YouTubeVideoViewsCountCrawler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'YouTube 조회수 크롤러';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $youTube = new YouTube();

        /** @var YouTubeUrlList $urlListRow */
        foreach (YouTubeUrlList::all() as $urlListRow) {
            $errorCheck = false;

            foreach ($youTube->getData($urlListRow->yul_url) as $crawlerData) {
                if (!array_key_exists('dataName', $crawlerData) && !array_key_exists('content', $crawlerData)) {
                    Log::error('YouTubeVideoViewsCountCrawler Data Error : url = ' . $urlListRow->yul_url . ' $crawlerData = ' . json_encode($crawlerData));
                    $errorCheck = true;
                    continue;
                }

                if ($crawlerData['dataName'] == 'name') {
                    /** @var YouTubeUrlList $youTubeUrlList */
                    $youTubeUrlList            = YouTubeUrlList::find($urlListRow->yul_no);
                    $youTubeUrlList->yul_title = $crawlerData['content'];
                    $youTubeUrlList->save();
                } elseif ($crawlerData['dataName'] == 'interactionCount') {
                    $youTubeViewsLog                 = new YouTubeViewsLog();
                    $youTubeViewsLog->yvl_yul_no     = $urlListRow->yul_no;
                    $youTubeViewsLog->yvl_registDate = date('Y-m-d H:i:s');
                    $youTubeViewsLog->yvl_views      = $crawlerData['content'];
                    $youTubeViewsLog->save();
                }
            }

            if ($errorCheck) {
                Telegram::allUserSendMsg('YouTubeVideoViewsCountCrawler Error url = ' . $urlListRow->yul_url);
            }
        }
    }
}
