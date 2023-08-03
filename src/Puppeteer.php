<?php

namespace PavloDotDev\PuppeteerPhp;

use Exception;

class Puppeteer
{
    public function __construct(
        protected readonly string $baseURL
    ) {
    }

    public function openPage(string $url): Page
    {
        $data = $this->request('/page', compact('url'));

        return Page::fromArray($data, $this);
    }

    public function getPage(string $id): Page
    {
        $data = $this->request('/page/'.$id);

        return Page::fromArray($data, $this);
    }

    public function request(string $path, array $post = null, int $timeout = 30)
    {
        $curl = curl_init($this->baseURL.$path);

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_CONNECTTIMEOUT => 10,
        ]);

        if (!is_null($post)) {
            curl_setopt_array($curl, [
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($post),
            ]);
        }

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            throw new Exception('curl '.curl_errno($curl).' - '.curl_error($curl));
        }

        curl_close($curl);

        $data = json_decode($response, true);
        if (!($data['success'] ?? false)) {
            throw new Exception($data['message'] ?? $response);
        }

        return $data;
    }
}