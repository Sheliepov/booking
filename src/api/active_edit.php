<?php
require_once "../Services/database.php";
require_once "../Model/tripModal.php";
require_once "../Controller/addNewTripController.php";

use Controller\TripController;

header('Content-Type: application/json');

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id']) && isset($data['active'])) {
    $id = (int)$data['id'];
    $active = (int)$data['active']; // Should be 0 or 1

    $tripController = new TripController();
    $result = $tripController->editActive($id, $active);

    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Trip active status updated.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update status.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Missing ID or Active value']);
}
