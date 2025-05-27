<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Models\Order;
use Carbon\Carbon;

class PayPalController extends Controller
{
    protected $clientId;
    protected $secret;
    protected $baseUrl;

    public function __construct()
    {
        $this->clientId = config('services.paypal.client_id');
        $this->secret = config('services.paypal.secret');
        $this->baseUrl = config('services.paypal.base_url');
    }

    private function getAccessToken()
    {
        if (!$this->clientId || !$this->secret) {
            abort(500, 'Credenciales PayPal no configuradas correctamente.');
        }

        $response = Http::withBasicAuth($this->clientId, $this->secret)
            ->asForm()
            ->post("{$this->baseUrl}/v1/oauth2/token", [
                'grant_type' => 'client_credentials',
            ]);

        return $response->json()['access_token'];
    }

    public function createOrder(Request $request)
    {
        $order = Order::findOrFail($request->order_id);

        $accessToken = $this->getAccessToken();

        $payload = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'EUR',
                        'value' => number_format($order->total, 2, '.', '')
                    ],
                    'description' => 'Pago FastFix Pedido #' . $order->id
                ]
            ],
            'application_context' => [
                'return_url' => url("/api/paypal/success?order_id={$order->id}"),
                'cancel_url' => env('FRONTEND_URL') . '/checkout/cancel'
            ]
        ];

        $response = Http::withToken($accessToken)
            ->post("{$this->baseUrl}/v2/checkout/orders", $payload);

        // 🚨 Agrega esto para ver todo
        logger()->error('📤 Payload enviado a PayPal:', $payload);
        logger()->error('📥 Respuesta de PayPal:', $response->json());

        if (!$response->successful()) {
            return response()->json([
                'error' => true,
                'message' => 'Error al crear orden PayPal',
                'paypal_response' => $response->json()
            ], $response->status());
        }

        return response()->json($response->json());
    }


    public function captureOrder(Request $request)
    {
        $orderId = $request->query('order_id');
        $paypalOrderId = $request->query('token');

        $accessToken = $this->getAccessToken();

        logger()->info('🔁 Capturando orden PayPal', [
            'order_id' => $orderId,
            'paypal_order_id' => $paypalOrderId,
        ]);

        $response = Http::withToken($accessToken)
            ->withBody('', 'application/json') // ✅ No enviar body vacío
            ->post("{$this->baseUrl}/v2/checkout/orders/{$paypalOrderId}/capture");

        $data = $response->json();

        logger()->info('📥 Resultado de captura', $data);

        if (isset($data['status']) && $data['status'] === 'COMPLETED') {
            $order = Order::findOrFail($orderId);

            $order->update([
                'estado' => 'pagado',
                'metodo_pago' => 'paypal',
                'paypal_payment_id' => $paypalOrderId,
                'paypal_status' => 'COMPLETED',
                'fecha_pago' => Carbon::now()
            ]);

            // ✅ Vaciar carrito por user_id del pedido
            if ($order->user_id) {
                CartItem::where('user_id', $order->user_id)->delete();
            }

            return response()->view('redirect', ['url' => env('FRONTEND_URL') . '/checkout/success']);
        }

        return response()->view('redirect', ['url' => env('FRONTEND_URL') . '/checkout/error']);
    }
}
