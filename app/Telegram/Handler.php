<?php

namespace App\Telegram;

use DefStudio\Telegraph\Handlers\WebhookHandler;
use Illuminate\Support\Facades\Cache;

class Handler extends WebhookHandler
{
    public function start($parameter = null): void
    {
        $telegramId = $this->message->from()->id();

        if (!$parameter) {
            $this->chat->message('👋 Вітаю! Щоб активувати бота, зайдіть через сайт.')->send();
            return;
        }

        $userId = Cache::pull('tg_register_' . $parameter);

        if (!$userId) {
            $this->chat->message('⛔️ Невірний або прострочений токен.')->send();
            return;
        }

        $user = \App\Models\User::find($userId);
        $user->update(['telegram_id' => $telegramId]);

        $this->chat->message("✅ Telegram успішно підключено до вашого акаунта!")->send();
    }
}
