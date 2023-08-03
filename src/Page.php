<?php

namespace PavloDotDev\PuppeteerPhp;

class Page
{
    public function __construct(
        public readonly Puppeteer $puppeteer,
        public readonly string $id,
        protected array $data,
    ) {
    }

    public function url(): string
    {
        return $this->data['url'];
    }

    public function content(): string
    {
        return $this->data['content'];
    }

    public function headers(): array
    {
        return $this->data['headers'];
    }

    public function cookies(): array
    {
        return $this->data['cookies'];
    }

    public function statusCode(): int
    {
        return $this->data['status'];
    }

    public function statusText(): string
    {
        return $this->data['statusText'];
    }

    public static function fromArray(array $data, Puppeteer $puppeteer): static
    {
        return new static(
            puppeteer: $puppeteer,
            id: $data['id'],
            data: $data,
        );
    }

    public function goto(string $url): Page
    {
        $this->data = $this->puppeteer->request('/page/'.$this->id.'/goto', compact('url'));

        return $this;
    }
}