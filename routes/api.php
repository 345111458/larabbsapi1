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


Route::prefix('v1')->namespace('Api')->middleware('change-locale')->name('api.v1.')->group(function () {


    Route::middleware('throttle:'.config('api.rate_limits.sign'))->group(function(){
        // 图片验证码
        Route::post('captchas', 'CaptchasController@store')->name('captchas.store');
        // 短信验证码
        Route::post('verificationCodes', 'VerificationCodesController@store')->name('verificationCodes.store');
        // 用户注册
        Route::post('users', 'UsersController@store')->name('users.store');
        // 第三方登录
        Route::post('socials/{social_type}/authorizations', 'AuthorizationsController@socialStore')
            ->where('social_type', 'weixin')->name('socials.authorizations.store');
        // 登录
        Route::post('authorizations', 'AuthorizationsController@store')->name('api.authorizations.store');
        // 刷新token
        Route::put('authorizations/current', 'AuthorizationsController@update')->name('authorizations.update');
        // 删除token
        Route::delete('authorizations/current', 'AuthorizationsController@destroy')->name('authorizations.destroy');


        // 游客可以访问的接口

        // 某个用户的详情
        Route::get('users/{user}', 'UsersController@show')->name('users.show');
        // 分类列表
        Route::get('categories', 'CategoriesController@index')->name('categories.index');
        // 某个用户发布的话题
        Route::get('users/{user}/topics', 'TopicController@userIndex')->name('users.topics.index');
        // 话题列表，详情
        Route::resource('topics', 'TopicController')->only([
            'index', 'show'
        ]);
        // 话题回复列表
        Route::get('topics/{topic}/replies', 'ReplyController@index')->name('topics.replies.index');
        // 某个用户的回复列表
        Route::get('users/{user}/replies', 'ReplyController@userIndex')->name('users.replies.index');
        // 资源推荐
        Route::get('links', 'LinksController@index')->name('links.index');
        // 活跃用户
        Route::get('actived/users', 'UsersController@activedIndex')->name('actived.users.index');





        // 登录后可以访问的接口
        Route::middleware('auth:api')->group(function() {
            // 当前登录用户信息
            Route::get('user', 'UsersController@me')->name('user.show');
            // 编辑登录用户信息
            Route::patch('user', 'UsersController@update')->name('user.update');
            // 上传图片
            Route::post('images', 'ImagesController@store')->name('images.store');
            // 发布话题
            Route::resource('topics', 'TopicController')->only([
                'store', 'update', 'destroy'
            ]);
            // 发布回复
            Route::post('topics/{topic}/replies','ReplyController@store')->name('topics.replies.store');
            // 删除回复
            Route::delete('topics/{topic}/replies/{reply}', 'ReplyController@destroy')->name('topics.replies.destroy');
            // 通知列表
            Route::get('notifications', 'NotificationController@index')->name('notifications.index');
            // 通知统计
            Route::get('notifications/stats', 'NotificationController@stats')->name('notifications.stats');
            // 标记消息通知为已读
            Route::patch('user/read/notifications', 'NotificationController@read')->name('user.notifications.read');
            // 当前登录用户权限
            Route::get('user/permissions', 'PermissionsController@index')->name('user.permissions.index');







        });



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


//    $code = '001fSa8S1nrhH51G5n7S173d8S1fSa8b';
//    $driver = Socialite::driver('weixin');
//    $response = $driver->getAccessTokenResponse($code);
//    $driver->setOpenId($response['openid']);
//    $oauthUser = $driver->userFromToken($response['access_token']);



});