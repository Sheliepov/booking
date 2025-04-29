<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once "../Services/database.php";
require_once "../Model/tripModal.php";
require_once "../Controller/addNewTripController.php";

use Controller\TripController;

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['tripID'], $input['date'], $input['available'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing parameters']);
    exit;
}

$tripID = (int)$input['tripID'];
$date = $input['date'];
$available = (int)$input['available'];

try {
    $controller = new TripController();
    $success = $controller->updateAvailable($tripID, $date, $available);

    if ($success) {
        echo json_encode(['status' => 'success']);
    } else {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Failed to update availability']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
