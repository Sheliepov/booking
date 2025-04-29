<?php
require_once "../../Services/database.php";
require_once "../../Model/picktimeModel.php";
require_once "../../Controller/pickTimeController.php";

use Controller\PickTimeController;

// Set header to return JSON
header('Content-Type: application/json');

// Read input
$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (isset($data['time']) && isset($data['tripID'])) {
    $time = $data['time'];
    $tripID = (int) $data['tripID'];

    $controller = new PickTimeController();
    $result = $controller->addPickTime($tripID, $time);

    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Pick time added successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add pick time']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Missing time or tripID']);
}