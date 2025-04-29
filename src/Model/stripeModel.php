<?php

namespace Model;

// require_once __DIR__ . '/../../../vendor/autoload.php';

use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeModel
{
    private $stripeSecretKey;

    public function __construct()
    {
        $this->stripeSecretKey = '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'; // ⚡ Your Stripe Secret Key
        Stripe::setApiKey($this->stripeSecretKey);
    }

    public function createCheckoutSession($amount)
    {
        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Trip Booking',
                        ],
                        'unit_amount' => $amount * 100, // Amount in cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => 'http://yourwebsite.com/success.php',
                'cancel_url' => 'http://yourwebsite.com/cancel.php',
            ]);

            return $session;
        } catch (\Exception $e) {
            throw new \Exception('Stripe Session Error: ' . $e->getMessage());
        }
    }
}
