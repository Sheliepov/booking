<?php

namespace Controller;

use Model\Order;

class OrderController
{
    private $orderModel;

    public function __construct()
    {
        $this->orderModel = new Order();
    }

    public function addOrder($tripID, $date, $pickTime, $returnTime, $adultNumber, $childNumber, $infantNumber, $fullNumber, $email, $phoneNumber, $roomNumber, $totalPrice)
    {
        return $this->orderModel->create($tripID, $date, $pickTime, $returnTime, $adultNumber, $childNumber, $infantNumber, $fullNumber, $email, $phoneNumber, $roomNumber, $totalPrice);
    }
}