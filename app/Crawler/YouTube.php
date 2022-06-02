<?php

namespace App\Crawler;

use Symfony\Component\Panther\Client;

class YouTube
{
    const HEADER           = ['HTTP_USER_AGENT' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.2 Safari/605.1.15'];
    const URL              = 'https://www.youtube.com';
    const FILTER_DATA_LIST = ['name', 'interactionCount', 'uploadDate'];

    private Client $domClient;

    public function clientRun(): void
    {
        $this->domClient = Client::createFirefoxClient();
    }

    public function getData($url): array
    {
        $client  = new \Goutte\Client();
        $request = $client->request('GET', $url, [], [], self::HEADER);
        $result  = $request->filter('meta')->each(function ($node) {
            if (in_array($node->attr('itemprop'), self::FILTER_DATA_LIST)) {
                return [
                    'dataName' => $node->attr('itemprop'),
                    'content'  => $node->attr('content'),
                ];
            }
            return [];
        });

        foreach ($result as $key => $listRow) {
            if (empty($listRow)) {
                unset($result[$key]);
            }
        }

        sort($result);

        return $result;
    }

    /**
     * 해당 채널명 최근 업로드 영상 리스트 가져오기
     *
     * @param string $channelUrl
     * @return array
     */
    public function getVideoList(string $channelUrl): array
    {
        $request = $this->domClient->request('GET', $channelUrl);
        $result  = $request->filter('#video-title')->each(function ($node) {
            return [
                'videoTitle' => $node->attr('title'),
                'address'    => $node->attr('href'),
            ];
        });

        foreach ($result as $key => $listRow) {
            if (empty($listRow)) {
                unset($result[$key]);
            }
        }

        sort($result);

        return $result;
    }
}
