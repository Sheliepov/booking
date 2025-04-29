<?php
require_once "../../Services/database.php";
require_once "../../Model/picktimeModel.php";
require_once "../../Controller/pickTimeController.php";

use Controller\PickTimeController;

// Set header
header('Content-Type: application/json');

// Read POST input
$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (isset($data['id']) && isset($data['time'])) {
    $id = (int) $data['id'];
    $time = $data['time'];

    $controller = new PickTimeController();
    $result = $controller->updatePickTime($id, $time);

    if ($result) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Pick time updated successfully!'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update pick time'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing id or time'
    ]);
}