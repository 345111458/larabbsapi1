<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('v1')->namespace('Api')->name('api.v1.')->group(function () {


    Route::middleware('throttle:'.config('api.rate_limits.sign'))->group(function(){
        // 图片验证码
        Route::post('captchas', 'CaptchasController@store')->name('captchas.store');
        // 短信验证码
        Route::post('verificationCodes', 'VerificationCodesController@store')->name('verificationCodes.store');
        // 用户注册
        Route::post('users', 'UsersController@store')->name('users.store');






    });


    Route::middleware('throttle:'.config('api.rate_limits.access'))->group(function(){


    });



//    https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx4abef2815c17e9b2&redirect_uri=http://larabbs.test&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect


//    https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx4abef2815c17e9b2&secret=f83356c3e197c2e758c96fe671b992bc&code=071ZB3zA0Xk5Wi26hByA09A2zA0ZB3zz&grant_type=authorization_code

//    https://api.weixin.qq.com/sns/userinfo?access_token=27_10IlyZ6QJO8W4629ALeawWeIyuk5wBaeK6h2I1t3CiaWuHvb9nbhB896gQX5UUdmSicNIg1vjOu-VI34a3T6Tw&openid=of1Qks6GQX08yEVySfHjUNSHtLsE&lang=zh_CN


//    $accessToken = '27_10IlyZ6QJO8W4629ALeawWeIyuk5wBaeK6h2I1t3CiaWuHvb9nbhB896gQX5UUdmSicNIg1vjOu-VI34a3T6Tw';
//    $openID = 'of1Qks6GQX08yEVySfHjUNSHtLsE';
//    $driver = Socialite::driver('weixin');
//    $driver->setOpenId($openID);
//    $oauthUser = $driver->userFromToken($accessToken);


    $code = '061RIluT1dAEC41rWetT1jTGuT1RIlu6';
    $driver = Socialite::driver('weixin');
    $response = $driver->getAccessTokenResponse($code);
    $driver->setOpenId($response['openid']);
    $oauthUser = $driver->userFromToken($response['access_token']);



});