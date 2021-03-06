<?php

/**
 * LaFa - A Laravel Fast Development Framework For Web Artisans
 *
 * @author   mofei <root@mofei.org>
 * @link     https://github.com/imofei/lafa
 */

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| 前台相关路由
|
*/
Route::group(['middleware' => ['frontend'], ], function () {
    // 前台所有URL必须加入 navigation 参数,否则面包屑无法正常使用
    // 站点首页
    Route::get('/', 'WelcomeController@index')->name('welcome');
    Route::get('index.html', 'WelcomeController@index')->name('index');

    // 栏目聚合页
    Route::get('category/show_{navigation}_{articleCategory}.html', 'ArticleController@category')->name('category.index');

    // 文章列表页
    Route::get('article/list_{navigation}_{articleCategory}.html', 'ArticleController@index')->name('article.index');

    // 文章详情页
    Route::get('article/show_{navigation}_{category}_{safeArticle}.html', 'ArticleController@show')->name('article.show');

    // 页面详情页
    Route::get('page/show_{navigation}_{safePage}.html', 'PageController@show')->name('page.show');

    // 在线留言
    Route::get('message/show_{navigation}.html', 'WelcomeController@message')->name('message.index');

    // 关于我们
    Route::get('company/show_{navigation}.html', 'WelcomeController@company')->name('company.index');

    // 站点地图
    Route::get('map/show_{navigation}.html', 'WelcomeController@map')->name('map.index');

    // 自定义表单
    Route::get('form/show_{navigation}_{type}.html', 'FormController@index')->name('form.index');
    Route::post('form/{type}.html', 'FormController@store')->name('form.store');

    // 搜索页面
    Route::get('search', 'SearchController@index')->name('search');

    // 测试
    Route::get('test', function(){
        $list = get_active_template();

        dump($list);
    });

    // 前台认证相关路由
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    // 登录
    Route::post('login', 'Auth\LoginController@login');
    // 注册
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    // 注册验证
    Route::post('register', 'Auth\RegisterController@register');
    // 重置密码
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    // 找回密码
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    // 找回密码
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    // 密码重置
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::get('user/home/{user}', 'UserController@home')->name('user.home');
    Route::get('login/{type}', 'Auth\LoginController@redirectToProvider')->name('oauth.login');
    Route::get('login/{type}/callback', 'Auth\LoginController@handleProviderCallback')->name('oauth.login.callback');
    Route::post('verificationCodes', 'VerificationCodesController@store')->name('verificationCodes.store');

    // 前台需要用户认证路由
    Route::group(['middleware' => ['auth']], function(){

        // 退出
        Route::get('logout', 'Auth\LoginController@logout')->name('logout');
        Route::get('login/{type}/unbind', 'Auth\LoginController@unbind')->name('oauth.login.unbind');

        // 用户中心
        Route::get('user/index', 'UserController@index')->name('user.index');
        Route::get('user/settings{type?}', 'UserController@settings')->name('user.settings');
        Route::get('user/messages', 'UserController@messages')->name('user.messages');
        Route::get('user/activate', 'UserController@activate')->name('user.activate');

        // 短信验证码
        Route::patch('user/update_info', 'UserController@updateInfo')->name('user.update_info');
        Route::patch('user/update_avatar', 'UserController@updateAvatar')->name('user.update_avatar');
        Route::patch('user/update_password', 'UserController@updatePassword')->name('user.update_password');

        // 回复
        Route::resource('replies', 'RepliesController', ['only' => ['store', 'destroy']]);

    });

});

// 文件上传相关路由
Route::post('uploader', 'UploadController@uploader')->name('uploader');
// 检查分片
Route::post('uploader/check/chunk', 'UploadController@checkChunk')->name('uploader.check.chunk');
// 检查MD5
Route::post('uploader/check/md5', 'UploadController@checkMd5')->name('uploader.check.md5');
// 合并分片
Route::post('uploader/merge/chunks', 'UploadController@mergeChunks')->name('uploader.merge.chunks');
// 图片路由
Route::get('storage/images/{one?}/{two?}/{three?}/{four?}/{five?}/{six?}/{seven?}/{eight?}/{nine?}/{ten?}',
    'UploadController@images')->name('images');
// 微信路由
Route::any('wechat/{safeWechat}.html', 'WeChatController@serve')->name('wechat.api');


/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
| 载入后台相关路由
|
*/
require __DIR__ . '/backend.php';
