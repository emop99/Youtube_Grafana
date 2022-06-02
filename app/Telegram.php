<?php

namespace App;

use Illuminate\Support\Facades\Log;

class Telegram extends InstanceClass
{
    const GET_CHAT_ID_API_URL = 'https://api.telegram.org/bot{{BOT_TOKEN/getUpdates';
    const SEND_MSG_API_URL    = 'https://api.telegram.org/bot{{BOT_TOKEN}}/sendmessage';
    const CHAT_ID_LIST        = [
        'emop99' => '53000314',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Telegram API URL Bot Token Setting
     *
     * @param string $apiUrl
     * @return string
     */
    private static function getApiUrlBotTokenSetting(string $apiUrl = ''): string
    {
        return str_replace('{{BOT_TOKEN}}', env('TELEGRAM_BOT_TOKEN', ''), $apiUrl);
    }

    /**
     * Telegram API Use Setting Checking
     *
     * @return bool
     */
    private static function useSettingCheck(): bool
    {
        return !!env('TELEGRAM_NOTICE_USE', 0);
    }

    private static function sendCurl($url): void
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_NOBODY, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//        $resultData = curl_exec($ch);
        $error = curl_error($ch);

        if ($error) {
            Log::error(__METHOD__ . '::' . $error);
        }

//        if ($resultData) {
//            return json_decode($resultData, true);
//        }
//
//        return [];
    }

    /**
     * 전체 유저에게 Send
     *
     * @param string $text
     */
    public static function allUserSendMsg(string $text)
    {
        if (!self::useSettingCheck()) {
            return;
        }
        foreach (self::CHAT_ID_LIST as $chatId) {
            self::sendCurl(self::getApiUrlBotTokenSetting(self::SEND_MSG_API_URL) . '?chat_id=' . $chatId . '&text=' . urlencode($text));
        }
    }
}
