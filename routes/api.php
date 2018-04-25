<?php

use App\User;
use Illuminate\Http\Request;
use Psr\Http\Message\ServerRequestInterface;

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

Route::middleware(['auth:api', 'scopes:profile,private'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/login', function (Request $request) {

    $http = new GuzzleHttp\Client;

    $response = $http->post('http://merry.test/api/auth/login', [
        'form_params' => [
            'email'    => $request->username,
            'password' => $request->password,
        ],
    ]);

    $result = json_decode((string) $response->getBody(), true);

    if (isset($result['data'])) {

        $user = User::updateOrCreate(
            [
                'email' => $request->username,
            ],
            [
                'name'     => $request->username,
                'email'    => $request->username,
                'password' => bcrypt($request->password),
            ]);

        $user->forcefill(['jwt_token' => $result['data']['token']])->save();

        $response2 = $http->post('http://passport.test/oauth/token', [
            'form_params' => [
                'grant_type'    => $request->grant_type,
                'client_id'     => $request->client_id,
                'client_secret' => $request->client_secret,
                'username'      => $request->username,
                'password'      => $request->password,
                'scope'         => $request->scope,
            ],
        ]);

        return json_decode((string) $response2->getBody(), true);
    }
});

Route::get('auth/user', function (Request $request) {
    $http = new GuzzleHttp\Client;

    $response = $http->get('http://merry.test/api/auth/user', [
        'headers' => ['Authorization' => 'Bearer ' . $request->user()->jwt_token],
    ]);

    return json_decode((string) $response->getBody(), true);
})->middleware('auth:api');
