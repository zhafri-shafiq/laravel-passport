<?php

namespace App\Extensions;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class MerryUserProvider implements UserProvider
{
    /**
     * @param Authenticatable $model
     */
    // public function __construct(Authenticatable $model)
    // {
    //     $this->model = $model;
    // }

    /**
     * @param $identifier
     */
    public function retrieveById($identifier)
    {

    }

    /**
     * @param $identifier
     * @param $token
     */
    public function retrieveByToken($identifier, $token)
    {

    }

    /**
     * @param Authenticatable $user
     * @param $token
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {

    }

    /**
     * @param array $credentials
     */
    public function retrieveByCredentials(array $credentials)
    {

    }

    /**
     * @param Authenticatable $user
     * @param array $credentials
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {

    }
}
