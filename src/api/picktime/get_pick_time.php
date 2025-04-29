<?php
require_once "../../Services/database.php";
require_once "../../Model/picktimeModel.php";
require_once "../../Controller/pickTimeController.php";

use Controller\PickTimeController;

// Set header
header('Content-Type: application/json');

// Read input
$data = json_decode(file_get_contents('php://input'), true);

// Validate
if (isset($data['tripID'])) {
    $tripID = (int) $data['tripID'];

    $controller = new PickTimeController();
    $pickTimes = $controller->getPickTimes($tripID);

    echo json_encode([
        'status' => 'success',
        'data' => $pickTimes
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing tripID'
    ]);
}
