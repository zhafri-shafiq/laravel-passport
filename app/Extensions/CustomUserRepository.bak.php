<?php

namespace App\Extensions;

use RuntimeException;
use App\Extensions\User;
use Illuminate\Hashing\HashManager;
use Illuminate\Contracts\Hashing\Hasher;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;

class CustomUserRepository implements UserRepositoryInterface
{
    /**
     * The hasher implementation.
     *
     * @var \Illuminate\Hashing\HashManager
     */
    protected $hasher;

    /**
     * Create a new repository instance.
     *
     * @param  \Illuminate\Hashing\HashManager  $hasher
     * @return void
     */
    public function __construct(HashManager $hasher)
    {
        $this->hasher = $hasher->driver();
    }

    /**
     * {@inheritdoc}
     */
    public function getUserEntityByUserCredentials($username, $password, $grantType, ClientEntityInterface $clientEntity)
    {
        $provider = config('auth.guards.api.provider');

        if (is_null($model = config('auth.providers.' . $provider . '.model'))) {
            throw new RuntimeException('Unable to determine authentication model from configuration.');
        }

        if (method_exists($model, 'findForPassport')) {
            $user = (new $model)->findForPassport($username);
        } else {
            // $user = (new $model)->where('email', $username)->first();
            $http = new \GuzzleHttp\Client;

            $response = $http->post('http://merry.test/api/auth/login', [
                'form_params' => [
                    'email'    => 'luffy@gmail.com',
                    'password' => 'password',
                ],
            ]);

            $result = json_decode((string) $response->getBody(), true)['data'];
            $user = new User();
            $user->id = $result['user']['id'];
            $user->name = $result['user']['name'];
            $user->email = $result['user']['email'];

        }

        if (!$user) {
            return;
        } elseif (method_exists($user, 'validateForPassportPasswordGrant')) {
            if (!$user->validateForPassportPasswordGrant($password)) {
                return;
            }
        } elseif (!$this->hasher->check($password, $user->getAuthPassword())) {
            return;
        }

        return new User($user->getAuthIdentifier());
    }
}
