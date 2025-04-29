<?php

namespace Controller;

use Model\StripeModel;

class StripeController
{
    private $stripeModel;

    public function __construct()
    {
        $this->stripeModel = new StripeModel();
    }

    public function createSession($amount)
    {
        return $this->stripeModel->createCheckoutSession($amount);
    }
}