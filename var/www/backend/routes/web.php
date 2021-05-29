<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/*
$app->group(['prefix'=>'api/v1'], function() use($app){
    $router->post('/login/register', 'LoginController@register');
});
*/

//test
$router->get('/index', 'HelloController@index');
$router->get('/test', 'HelloController@test');
$router->get('/api', 'HelloController@api');
$router->get('/img', 'HelloController@img');
$router->get('/ctrl/upload', 'HelloController@upload');
$router->get('/json_test', 'HelloController@json_test');
//$router->post('/ctrl/uploadfile', 'HelloController@uploadfile');
//$router->post('/ctrl/uploadfile', 'PostController@post');
$router->get('/mail', 'HelloController@mail');
$router->get('/testmail', function(){
    Mail::to('test@example.com')->send(new TestMail);
    return 'メール送信完了';
});
$router->get('/send_mail', 'HelloController@sendmail');
$router->get('/test_mail', 'HelloController@test_mail');

//ログイン部分
$router->post('/login/register', 'LoginController@register');
$router->get('/loginc/test', 'LoginController@test');

//登録部分
$router->post('/register', 'RegisterController@register');

//メール登録
$router->get('/register/mail/{login_id}', 'RegisterController@true_register');

//投稿部分
$router->get('/post/form', 'PostController@form');
$router->post('/keijiban/post', 'PostController@post');

//削除パスワード確認
$router->post('save/delete/pass', 'SaveController@delete_pass');
//削除部分
$router->delete('save/delete/{id}', 'SaveController@delete');

//編集パスワード確認
$router->post('save/edit_pass/pass', 'SaveController@edit_pass');
//編集部分
$router->post('save/edit/{id}', 'SaveController@edit');