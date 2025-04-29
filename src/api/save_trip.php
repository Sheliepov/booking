<?php
// Load your classes
require_once "../Services/database.php";
require_once "../Model/tripModal.php";
require_once "../Controller/addNewTripController.php";

use Controller\TripController;

// Step 1: Receive JSON data
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $tripName = $data['tripName'];
    $adultPrice = $data['adultPrice'];
    $childPrice = $data['childPrice'];
    $infantPrice = $data['infantPrice'];
    $available = $data['available'];
    $active = $data['active'];

    // Step 2: Save trip
    $tripController = new TripController();
    $result = $tripController->saveTrip($tripName, $adultPrice, $childPrice, $infantPrice, $available, $active);

    // Step 3: Return success
} else {
    echo json_encode(['status' => 'error', 'message' => 'No data received']);
}
