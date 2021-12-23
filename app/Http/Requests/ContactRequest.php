<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * バリデーション属性名
     *
     * @return void
     */
    public function attributes()
    {
        return [
            'name' => 'お名前',
            'email' => 'メールアドレス',
            'title' => 'タイトル',
            'body' => '問い合わせ内容',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => ['required','max:255'],
            'email' => ['required', 'email:strict,dns,spoof'],
            'title' => ['required','max:255'],
            'body'  => ['required'],
        ];
    }
}
