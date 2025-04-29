<?php
require_once "../Services/database.php";
require_once "../Model/tripModal.php";
require_once "../Controller/addNewTripController.php";

use Controller\TripController;

// Set header to return JSON
header('Content-Type: application/json');

// Initialize controller
$tripController = new TripController();

// Get all trips
$trips = $tripController->getAllTrips();

// Return as JSON
echo json_encode([
    'status' => 'success',
    'data' => $trips
]);
