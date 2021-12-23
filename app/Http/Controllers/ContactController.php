<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactForm;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * お問い合わせメールフォームの表示
     *
     * @return void
     */
    public function index()
    {
        return view('contact.index');
    }

    /**
     * お問い合わせ内容確認画面表示
     *
     * @param Request $request
     * @return void
     */
    public function confirm(ContactRequest $request)
    {
        //フォームから受け取ったすべてのinputの値を取得
        $contact = $request->all();
        //画面遷移してもフォームの内容維持
        session()->flashInput($request->input());
        return view('contact.confirm', compact('contact'));
    }

    /**
     * メール送信と送信完了画面表示
     *
     * @param Request $request
     * @return void
     */
    public function send(ContactRequest $request)
    {
        try {
            //メール送信
            $data = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'title' => $request->input('title'),
                'body' => $request->input('body')
            ];

            Mail::to(env('MAIL_FROM_ADDRESS'))->send(new ContactForm($data));
            Mail::to($data['email'])->send(new ContactForm($data));

            //再送信を防ぐためにトークンを再発行
            $request->session()->regenerateToken();

            //リダイレクト
            return view('contact.thanks');
        } catch (\Throwable $e) {
            return back()->with('flash_alert', 'メール送信に失敗しました。');
            // 全てのエラー・例外をキャッチしてログに残す
            Log::error($e);
        }
    }
}
