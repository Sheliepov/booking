<?php
require_once "../Services/database.php";
require_once "../Model/tripModal.php";
require_once "../Controller/addNewTripController.php";

use Controller\TripController;

// Set header to return JSON
header('Content-Type: application/json');

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $id = (int) $data['id'];

    $tripController = new TripController();
    $result = $tripController->removeTrip($id);

    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Trip removed successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to remove trip.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Missing ID']);
}