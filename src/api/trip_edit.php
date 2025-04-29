<?php
require_once "../Services/database.php";
require_once "../Model/tripModal.php";
require_once "../Controller/addNewTripController.php";

use Controller\TripController;

header('Content-Type: application/json');

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id']) && isset($data['adultPrice']) && isset($data['childPrice']) && isset($data['infantPrice'])) {
    $id = (int)$data['id'];
    $adultPrice = (float)$data['adultPrice'];
    $childPrice = (float)$data['childPrice'];
    $infantPrice = (float)$data['infantPrice'];

    $tripController = new TripController();
    $result = $tripController->editTrip($id, $adultPrice, $childPrice, $infantPrice);

    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Trip updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update trip.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Missing fields']);
}
