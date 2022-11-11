<?php

namespace Punchlist\SocialiteWebflow;

use GuzzleHttp\Exception\GuzzleException;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\User;

class SocialiteWebflowProvider extends AbstractProvider
{
    /**
     * @return string
     */
    public function getWebflowUrl()
    {
        return config('services.webflow.base_uri') . '/oauth';
    }

    /**
     * @param  string  $state
     * @return string
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase($this->getWebflowUrl() . '/authorize', $state);
    }

    /**
     * @return string
     */
    protected function getTokenUrl()
    {
        return $this->getWebflowUrl() . '/access_token';
    }

    protected function getApiUrl()
    {
        return 'https://api.webflow.com';
    }

    /**
     * @param  string  $token
     * @return array|mixed
     *
     * @throws GuzzleException
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->post($this->getWebflowUrl() . '/user', [
            'headers' => [
                'cache-control' => 'no-cache',
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @return User
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id' => $user['_id'],
            'nickname' => null,
            'name' => $user['firstName'] . ' ' . $user['lastName'],
            'email' => $user['email'],
            'avatar' => 'https://www.gravatar.com/avatar/' . md5($user['email']),
        ]);
    }
}