<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use pschocke\TelegramLoginWidget\Facades\TelegramLoginWidget;

class TelegramCallbackController extends Controller
{
    public function __invoke(Request $request)
    {
        if (!$telegramUser = TelegramLoginWidget::validate($request)) {
            return redirect()->route('account.main')->with(['warn' => 'Telegram response is not valid!']);
        }

        auth()->user()->update([
           'telegram_user_id' => $telegramUser->get('id')
        ]);

        return redirect()->route('account.main')->with(['status' => 'Congratulations!']);
    }
}
