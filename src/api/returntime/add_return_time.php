<?php
require_once "../../Services/database.php";
require_once "../../Model/returntimeModel.php";
require_once "../../Controller/returnTimeController.php";

use Controller\ReturnTimeController;

// Set header
header('Content-Type: application/json');

// Read POST input
$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (isset($data['time']) && isset($data['tripID'])) {
    $time = $data['time'];
    $tripID = (int) $data['tripID'];

    $controller = new ReturnTimeController();
    $result = $controller->addReturnTime($tripID, $time);

    if ($result) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Return time added successfully!'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to add return time'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing time or tripID'
    ]);
}