<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;

class RecaptchaV2Async
{
    protected $http;
    protected $secret;
    protected $origin = 'https://www.google.com/recaptcha';

    public function __construct()
    {
        $this->http = new Client();
        $this->secret = config('services.recaptcha.secret_key'); // Load secret key from config
    }

    /**
     * Verify reCAPTCHA v2 asynchronously.
     *
     * @param string $token
     * @return PromiseInterface
     */
    public function verifyAsync($token): PromiseInterface
    {
        return $this->http->requestAsync('POST', $this->origin . '/api/siteverify', [
            'form_params' => [
                'secret'   => $this->secret,
                'response' => $token,
                'remoteip' => request()->ip(),
            ],
        ])->then(function (Response $response) {
            $body = json_decode($response->getBody(), true);

            if (!isset($body['success']) || $body['success'] !== true) {
                return false;
            }

            return isset($body['score']) ? $body['score'] : false;
        });
    }
}
