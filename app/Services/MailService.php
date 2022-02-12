<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Mail\ContactForm;
use Illuminate\Support\Facades\Log;

class MailService
{
    /**
     * メール送信
     *
     * @return void
     */
    public static function sendMail($request)
    {
        try {
            $data = [
                'name'  => $request->input('name'),
                'email' => $request->input('email'),
                'title' => $request->input('title'),
                'body'  => $request->input('body')
            ];
            //メール送信
            Mail::to(env('MAIL_FROM_ADDRESS'))->send(new ContactForm($data));
            Mail::to($data['email'])->send(new ContactForm($data));
            //再送信を防ぐためにトークンを再発行
            $request->session()->regenerateToken();
        } catch (\Throwable $e) {
            return back()->with('flash_alert', 'メール送信に失敗しました。');
            // 全てのエラー・例外をキャッチしてログに残す
            Log::error($e);
        }
    }
}
