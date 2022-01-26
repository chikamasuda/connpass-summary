<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ContactRequest;
use Tests\TestCase;

class ContactValidationTest extends TestCase
{
    /**
   * 新規登録のフォームリクエストのバリデーションテスト
   *
   * @param array 項目名の配列
   * @param array 値の配列
   * @param boolean 期待値(true:バリデーションOK, false:バリデーションNG)
   * @dataProvider ContactCreationProvider
   */
  public function testContactCreation(array $keys, array $values, bool $expect)
  {
    //入力項目の配列($keys)と値の配列($values)から、連想配列を生成する
    $dataList = array_combine($keys, $values);

    $request = new ContactRequest();
    //フォームリクエストで定義したルールを取得
    $rules = $request->rules();
    //validatorファザードでバリデーターのインスタンスを取得、その際に入力情報をバリデーションルールを引数で渡す
    $validator = Validator::make($dataList, $rules);
    //入力情報がバリデーションルールを満たしている場合はtrue,満たしていない場合はfalseが返る
    $result = $validator->passes();
    //期待値（＄expect）と結果($result）を比較
    $this->assertEquals($expect, $result);
  }

  public function ContactCreationProvider()
  {
    return [
      'ok' => [
        ['name', 'email', 'title', 'body'],
        ['testuser', 'test@example.com', 'テスト', 'テストユーザーです。'],
        true
      ],
      '名前必須エラー' => [
        ['name', 'email', 'title', 'body'],
        [null, 'test@example.com', 'テスト', 'テストユーザーです。'],
        false
      ],
      '名前最大文字数エラー' => [
        ['name', 'email', 'title', 'body'],
        [str_repeat('a', 256), 'test@example.com', 'テスト', 'テストユーザーです。'],
        false
      ],
      'ok' => [
        ['name', 'email', 'title', 'body'],
        [str_repeat('a', 255), 'test@example.com', 'テスト', 'テストユーザーです。'],
        true
      ],
      'email必須エラー' => [
        ['name', 'email', 'title', 'body'],
        ['testuser', null, 'テスト', 'テストユーザーです。'],
        false
      ],
      'email形式エラー' => [
        ['name', 'email', 'password', 'password_confirmation', 'language', 'address', 'self_introduction'],
        ['testuser', 'test@example.com', 'password', 'password', 'PHP', '東京都', 'テストユーザーです。'],
        false
      ],
      'title必須エラー' => [
        ['name', 'email', 'title', 'body'],
        ['testuser', 'test@example.com', null, 'テストユーザーです。'],
        false
      ],
      'title最大文字数エラー' => [
        ['name', 'email', 'title', 'body'],
        [ 'testuser', 'test@example.com', str_repeat('a', 256), 'テストユーザーです。'],
        false
      ],
      'ok' => [
        ['name', 'email', 'title', 'body'],
        [ 'testuser', 'c.m.062820@gmail.com', str_repeat('a', 255), 'テストユーザーです。'],
        true
      ],
      'body必須エラー' => [
        ['name', 'email', 'title', 'body'],
        ['testuser', 'test@example.com', 'テスト', null],
        false
      ],
    ];
  }
}
