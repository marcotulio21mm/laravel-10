<?php

namespace App\Http\Libs\Connections;

use Exception;

class Curl
{
    private $ch;
    private $customHeaders;

    public function __construct()
    {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, false);
        $this->customHeaders = array();
    }

    public function setCustomHeaders(array $headers): void
    {
        $this->customHeaders = $headers;
    }

    public function get(string $url): array
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        return $this->execute();
    }

    public function post(string $url, mixed $data): array
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, is_array($data) ? json_encode($data) : $data);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->customHeaders);
        return $this->execute();
    }

    private function execute(): array
    {
        $response = curl_exec($this->ch);
        if ($response === false) {
            throw new Exception(curl_error($this->ch));
        }
        return json_decode($response, true);
    }

    public function __destruct()
    {
        curl_close($this->ch);
    }
}
