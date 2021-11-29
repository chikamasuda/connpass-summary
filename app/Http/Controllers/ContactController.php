<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactForm;

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

    public function confirm(Request $request)
    {
        //バリデーションを実行（結果に問題があれば処理を中断してエラーを返す）
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email',
            'title' => 'required',
            'body'  => 'required',
        ]);
        
        //フォームから受け取ったすべてのinputの値を取得
        $contact = $request->all();
        //画面遷移してもフォームの内容維持
        session()->flashInput($request->input());
        return view('contact.confirm', compact('contact'));
    }

    public function send(Request $request)
    {
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
    }
}
