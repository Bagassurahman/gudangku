<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsappService
{
    private $apiHost;

    public function __construct()
    {
        $this->apiHost = config('services.whatsapp.host');
    }

    public function sendMessage($number, $message)
    {
        return Http::post($this->apiHost . "send-message", [
            'number' => $number,
            'message' => $message
        ]);
    }
}
