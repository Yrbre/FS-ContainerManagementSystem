<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Log;

class WhatspieService
{
    protected $client;

    public function __construct()
    {
        $url = rtrim((string) config('services.whatspie.url'), '/');

        if ($url === '') {
            Log::error('WHATSPIE_API_URL belum diisi di .env');
        }

        $this->client = new Client([
            'base_uri' => $url . '/',
            RequestOptions::CONNECT_TIMEOUT => (int) config('services.whatspie.connect_timeout', 5),
            RequestOptions::TIMEOUT => (int) config('services.whatspie.timeout', 30),
            RequestOptions::HEADERS => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'x-api-key' => (string) config('services.whatspie.secret'),
            ],
        ]);
    }

    public function startSession()
    {
        return $this->getBody('session/start/' . $this->session());
    }

    public function getStatus()
    {
        return $this->getBody('session/status/' . $this->session());
    }

    public function terminateSession()
    {
        return $this->getBody('session/terminate/' . $this->session());
    }

    public function fetchQRCode()
    {
        try {
            $response = $this->client->get('session/qr/' . $this->session() . '/image');

            $contentType = $response->getHeader('Content-Type')[0] ?? '';
            $content = (string) $response->getBody();

            if (strpos($contentType, 'image/') !== false) {
                // Response is an image
                return ['success' => true, 'qrcode' => $content];
            }

            // Response is JSON
            $body = json_decode($content, true);

            if (isset($body['success']) && $body['success'] === true) {
                return ['success' => true, 'qrcode' => $content];
            }

            return [
                'success' => false,
                'message' => isset($body['message']) ? $body['message'] : 'Failed to fetch QR code image',
            ];
        } catch (RequestException $e) {
            $message = $e->getMessage();

            if ($e->hasResponse()) {
                $json = json_decode((string) $e->getResponse()->getBody(), true);
                if (isset($json['message'])) {
                    $message = $json['message'];
                }
            }

            return ['success' => false, 'message' => $message];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function sendMessageToGroup($message)
    {
        if (!config('services.whatspie.secret')) {
            return;
        }

        try {
            $response = $this->client->post('client/sendMessage/' . $this->session(), [
                RequestOptions::JSON => [
                    'chatId' => config('services.whatspie.group'),
                    'contentType' => 'string',
                    'content' => $message,
                ],
            ]);

            $body = json_decode((string) $response->getBody(), true);
            Log::info('WhatsApp message sent successfully', is_array($body) ? $body : []);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $errorBody = (string) $e->getResponse()->getBody();
                Log::error('WhatsApp API Error Response: ' . $errorBody);
            } else {
                Log::error('WhatsApp API Request Error: ' . $e->getMessage());
            }
        } catch (\Throwable $e) {
            Log::error('Unexpected error in sendMessageToGroup: ' . $e->getMessage());
        }
    }

    protected function session()
    {
        return config('services.whatspie.session');
    }

    protected function getBody($path)
    {
        try {
            return $this->client->get($path)->getBody()->getContents();
        } catch (\Exception $e) {
            Log::warning('Whatspie request gagal: ' . $path . ' - ' . $e->getMessage());

            return null;
        }
    }
}