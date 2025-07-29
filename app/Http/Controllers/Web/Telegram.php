<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Telegram extends Controller
{
    public function __invoke()
    {
        $token = Str::random(32);
        Cache::put('tg_register_'.$token, auth()->id(), now()->addMinutes(15));

        $url = "https://t.me/tz_notification_bot?start={$token}";

        return redirect($url);
    }
}
