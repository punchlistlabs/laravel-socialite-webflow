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
        return config('services.webflow.api_url', 'https://api.webflow.com');
    }

    /**
     * @param  string  $token
     * @return array|mixed
     *
     * @throws GuzzleException
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get($this->getApiUrl() . '/user', [
            'headers' => [
                'cache-control' => 'no-cache',
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true)['user'];
    }

    /**
     * Format user data
     *
     * @param  array  $user - array of user data
     * @return User
     */
    protected function mapUserToObject(array $user)
    {
        // check names since data doesn't always looks consistent
        $firstName = isset($user['firstName']) ? $user['firstName'] : '';
        $lastName = isset($user['lastName']) ? $user['lastName'] : '';
        $name = $firstName . ' ' . $lastName;

        return (new User())->setRaw($user)->map([
            'id' => $user['_id'],
            'nickname' => null,
            'name' => $name,
            'email' => $user['email'],
            'avatar' => 'https://www.gravatar.com/avatar/' . md5($user['email']),
        ]);
    }
}
