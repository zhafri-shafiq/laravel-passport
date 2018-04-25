<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/merry-auth', function () {
    $http = new GuzzleHttp\Client;

    $response = $http->post('http://merry.test/api/auth/login', [
        'form_params' => [
            'email'    => 'luffy@gmail.com',
            'password' => 'password',
        ],
    ]);

    $result = json_decode((string) $response->getBody(), true)['data'];

    dd($result['user']);

    return json_decode((string) $response->getBody(), true);
});

Route::get('/merry-user', function () {
    $http = new GuzzleHttp\Client;

    $response = $http->get('http://merry.test/api/auth/user', [
        // 'form_params' => [
        //     'token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6Ly9tZXJyeS50ZXN0L2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNTI0NjMwNDA4LCJleHAiOjE1MjQ2MzQwMDgsIm5iZiI6MTUyNDYzMDQwOCwianRpIjoieU9LcnRrUTFHVEtDWFFVYSJ9.8QobBjEeG80qy-OcQIRCRih_p_KBzVFAAbycSPyIF6s',
        // ],
        'headers' => ['Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6Ly9tZXJyeS50ZXN0L2FwaS9hdXRoL2xvZ2luIiwiaWF0IjoxNTI0NjM2Mjc3LCJleHAiOjE1MjQ2Mzk4NzcsIm5iZiI6MTUyNDYzNjI3NywianRpIjoiOGpzQjdWdExWWG5oOW80eiJ9.DrIKl4CazqPaSSWRR71PJrE28CNiYRUgF4wm7VxjhQ0'],
    ]);

    return json_decode((string) $response->getBody(), true);
});
