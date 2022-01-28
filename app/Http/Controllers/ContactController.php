<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactForm;
use App\Services\MailService;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    private $mail_service;

    public function __construct(MailService $mail_service)
    {
        $this->mail_service = $mail_service;
    }

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
        $this->mail_service->sendMail($request);

        return view('contact.thanks');
    }
}
