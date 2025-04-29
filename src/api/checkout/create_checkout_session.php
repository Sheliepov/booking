<?php
// create_checkout_session.php

// require 'config.php';
require '../../../config.php';

header('Content-Type: application/json'); // Return JSON response

try {
    // Create a Stripe Checkout Session
    $checkout_session = \Stripe\Checkout\Session::create([
        'mode' => 'payment', // or 'subscription' for recurring
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => 'Sample Product', // product name
                ],
                'unit_amount' => 5000, // $50.00 in cents
            ],
            'quantity' => 1,
        ]],
        'success_url' => 'https://yourdomain.com/success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => 'https://yourdomain.com/cancel.php',
    ]);

    // Send session id as JSON
    echo json_encode(['id' => $checkout_session->id]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}