<?php
require_once "../../Services/database.php";
require_once "../../Model/picktimeModel.php";
require_once "../../Controller/pickTimeController.php";

use Controller\PickTimeController;

// Set header
header('Content-Type: application/json');

// Read POST input
$data = json_decode(file_get_contents('php://input'), true);

// Validate
if (isset($data['id'])) {
    $id = (int) $data['id'];

    $controller = new PickTimeController();
    $result = $controller->removePickTime($id);

    if ($result) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Pickup time deleted successfully!'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to delete pickup time'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing ID'
    ]);
}