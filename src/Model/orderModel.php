<?php

namespace Model;

use Service\Database;

class Order
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->conn;
    }

    public function create($tripID, $date, $pickTime, $returnTime, $adultNumber, $childNumber, $infantNumber, $fullNumber, $email, $phoneNumber, $roomNumber, $totalPrice)
    {
        $stmt = $this->db->prepare("INSERT INTO orders (trip_id, date, pick_time, return_time, adult_number, child_number, infant_number, full_number, email, phone_number, room_number, total_price)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "isssiiissssd",
            $tripID,
            $date,
            $pickTime,
            $returnTime,
            $adultNumber,
            $childNumber,
            $infantNumber,
            $fullNumber,
            $email,
            $phoneNumber,
            $roomNumber,
            $totalPrice
        );

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}