<?php
require_once "../../Services/database.php";
require_once "../../Model/orderModel.php";
require_once "../../Controller/orderController.php";

use Controller\OrderController;

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (
    isset(
        $data['tripID'],
        $data['date'],
        $data['pickTime'],
        $data['returnTime'],
        $data['adultNumber'],
        $data['childNumber'],
        $data['infantNumber'],
        $data['fullName'],
        $data['email'],
        $data['phoneNumber'],
        $data['roomNumber'],
        $data['totalPrice']
    )
) {
    $controller = new OrderController();
    $result = $controller->addOrder(
        (int) $data['tripID'],
        $data['date'],
        $data['pickTime'],
        $data['returnTime'],
        (int) $data['adultNumber'],
        (int) $data['childNumber'],
        (int) $data['infantNumber'],
        $data['fullName'],
        $data['email'],
        $data['phoneNumber'],
        $data['roomNumber'],
        (float) $data['totalPrice']
    );

    if ($result) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Order placed successfully!'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to place order'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing required fields'
    ]);
}