<?php

namespace App\Http\Libs\Connections;

use App\Constants;

class PayPal
{
    private $base_url;
    private $curlClient;
    private $accessToken;
    private $tokenExpiration;
    private $clientId;
    private $secret;

    public function __construct()
    {
        $this->base_url = Constants::PAYPAL_URL;
        $this->curlClient = new Curl();
        $this->clientId = getenv('PAYPAL_CLIENT_ID');
        $this->secret = getenv('PAYPAL_SECRET');
    }

    public function get(string $endpoint): array
    {
        $url = $this->base_url . $endpoint;
        return $this->curlClient->get($url);
    }

    public function post(string $endpoint, array $data): array
    {
        $url = $this->base_url . $endpoint;
        $this->addAuthorizationHeader($this->getAccessToken());
        return $this->curlClient->post($url, $data);
    }

    public function addAuthorizationHeader(string $accessToken): void
    {
        $headers = array(
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        );
        $this->curlClient->setCustomHeaders($headers);
    }

    public function getAccessToken(): string
    {
        if ($this->accessToken && !$this->isTokenExpired()) {
            return $this->accessToken;
        }
        $response = $this->fetchNewAccessToken();
        $this->accessToken = $response['access_token'];
        $this->tokenExpiration = time() + $response['expires_in']; // Define o tempo de expiração
        return $this->accessToken;
    }

    private function isTokenExpired(): bool
    {
        if (!$this->accessToken || !$this->tokenExpiration) {
            return true;
        }

        $now = time();
        return $now >= $this->tokenExpiration;
    }

    private function fetchNewAccessToken(): array
    {
        $url = $this->base_url . 'v1/oauth2/token';
        $data = 'grant_type=client_credentials';
        $this->curlClient->setCustomHeaders($this->getCustomHeadersToAuth());
        $response = $this->curlClient->post($url, $data);
        $this->accessToken = $response['access_token'];
        return $response;
    }

    private function getCustomHeadersToAuth(): array
    {
        $headers = array(
            'Authorization: Basic ' . base64_encode($this->clientId . ':' . $this->secret),
            'Content-Type: application/x-www-form-urlencoded',
        );
        return $headers;
    }
}
