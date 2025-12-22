<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;

class RecaptchaV3Async
{
    protected $http;
    protected $secret;
    protected $origin = 'https://www.google.com/recaptcha/api/siteverify';

    public function __construct()
    {
        $this->http = new Client();
        $this->secret = config('services.recaptcha.secret_key'); // Load secret key from config
    }

    /**
     * Verify reCAPTCHA v3 asynchronously with score validation.
     *
     * @param string $token
     * @return PromiseInterface
     */
    public function verifyAsync($token): PromiseInterface
    {
        return $this->http->requestAsync('POST', $this->origin, [
            'form_params' => [
                'secret'   => $this->secret,
                'response' => $token,
                'remoteip' => request()->ip(),
            ],
        ])->then(function (Response $response) {
            $body = json_decode($response->getBody(), true);

            // Check if the request was successful
            if (!isset($body['success']) || $body['success'] !== true) {
                return false;
            }

            // Validate score (reCAPTCHA v3 returns a score between 0.0 and 1.0)
            $score = $body['score'] ?? 0;
            return $score >= config('services.recaptcha.min_score', 0.5); // Set minimum score in config
        });
    }
}
