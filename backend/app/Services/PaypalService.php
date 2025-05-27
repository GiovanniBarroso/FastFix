<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaypalService
{
    protected $clientId;
    protected $clientSecret;
    protected $baseUrl;
    protected $currency;

    public function __construct()
    {
        $mode = config('paypal.mode');
        $this->clientId = config("paypal.{$mode}.client_id");
        $this->clientSecret = config("paypal.{$mode}.client_secret");
        $this->baseUrl = config("paypal.base_url.{$mode}");
        $this->currency = config('paypal.currency');
    }

    public function getAccessToken()
    {
        $response = Http::withBasicAuth($this->clientId, $this->clientSecret)
            ->asForm()
            ->post("{$this->baseUrl}/v1/oauth2/token", [
                'grant_type' => 'client_credentials'
            ]);

        return $response->json()['access_token'] ?? null;
    }

    public function createOrder($amount)
    {
        $token = $this->getAccessToken();

        $response = Http::withToken($token)->post("{$this->baseUrl}/v2/checkout/orders", [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => $this->currency,
                        'value' => number_format($amount, 2, '.', '')
                    ]
                ]
            ],
            'application_context' => [
                'return_url' => route('paypal.success'),
                'cancel_url' => route('paypal.cancel')
            ]
        ]);

        return $response->json();
    }

    public function captureOrder($orderId)
    {
        $token = $this->getAccessToken();

        $response = Http::withToken($token)
            ->post("{$this->baseUrl}/v2/checkout/orders/{$orderId}/capture");

        return $response->json();
    }
}

