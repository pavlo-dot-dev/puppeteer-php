<?php
require 'vendor/autoload.php';

$client = new \PavloDotDev\PuppeteerPhp\Puppeteer('http://127.0.0.1:3000');

$page = $client->openPage('https://google.com');

print_r($page);