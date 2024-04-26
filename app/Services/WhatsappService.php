<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsappService
{
    private $apiHost;
    private $apiKey;

    public function __construct()
    {
        $this->apiHost = config('services.whatsapp.host');
        $this->apiKey = config('services.whatsapp.key');
    }

    public function sendMessage($number, $message)
    {
        $formattedNumber = preg_replace('/^0/', '62', $number);

        return Http::post($this->apiHost . "send-message", [
            'api_key' => $this->apiKey,
            'receiver' => $formattedNumber,
            'data' => [
                'message' => $message
            ]
        ]);
    }
}
