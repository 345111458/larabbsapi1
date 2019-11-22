<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CaptchRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Gregwar\Captcha\CaptchaBuilder;



class CaptchasController extends Controller
{
    public function store(CaptchRequest $request, CaptchaBuilder $captchaBuilder)
    {
        $key = 'captcha-'.Str::random(15);
        $phone = $request->phone;

        $captcha = $captchaBuilder->build();
        $expiredAt = now()->addMinutes(2);
        \Cache::put($key, ['phone' => $phone, 'code' => $captcha->getPhrase()], $expiredAt);

        $result = [
            'captcha_key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
            'codes' =>  $captcha->getPhrase(),
            'captcha_image_content' => $captcha->inline()
        ];

        return response()->json($result)->setStatusCode(201);
    }
    //
}
