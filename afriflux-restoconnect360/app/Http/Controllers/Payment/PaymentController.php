<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payment\Payment;
use App\Models\Restaurant\Order;
use App\Services\CinetPayService;
use App\Services\PayTechService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private CinetPayService $cinetpayService;
    private PayTechService $paytechService;

    public function __construct(
        CinetPayService $cinetpayService,
        PayTechService $paytechService
    ) {
        $this->cinetpayService = $cinetpayService;
        $this->paytechService = $paytechService;
    }

    /**
     * Initialize payment
     */
    public function initialize(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_method' => 'required|in:cinetpay,paytech,cash',
            'customer_name' => 'required|string',
            'customer_phone' => 'required|string',
        ]);

        $order = Order::find($request->order_id);

        if ($order->payment_status === 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Cette commande est déjà payée.',
            ], 400);
        }

        $customerData = [
            'name' => $request->customer_name,
            'phone' => $request->customer_phone,
            'email' => $request->customer_email,
        ];

        $result = match ($request->payment_method) {
            'cinetpay' => $this->cinetpayService->initializePayment($order, $customerData),
            'paytech' => $this->paytechService->initializePayment($order, $customerData),
            'cash' => $this->handleCashPayment($order),
            default => ['success' => false, 'message' => 'Méthode de paiement non supportée'],
        };

        return response()->json($result);
    }

    /**
     * Handle cash payment
     */
    private function handleCashPayment(Order $order): array
    {
        $payment = Payment::create([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'payment_method' => 'cash',
            'amount' => $order->total,
            'currency' => 'XOF',
            'status' => 'pending',
        ]);

        return [
            'success' => true,
            'payment' => $payment,
            'message' => 'Paiement en espèces enregistré.',
        ];
    }

    /**
     * Get payment status
     */
    public function status(Payment $payment)
    {
        return response()->json([
            'success' => true,
            'payment' => $payment->load('order'),
        ]);
    }

    /**
     * CinetPay webhook
     */
    public function cinetpayWebhook(Request $request)
    {
        $this->cinetpayService->handleWebhook($request->all());

        return response()->json(['success' => true]);
    }

    /**
     * PayTech IPN
     */
    public function paytechWebhook(Request $request)
    {
        $this->paytechService->handleIPN($request->all());

        return response()->json(['success' => true]);
    }
}

