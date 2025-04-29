<?php
require_once "../../Services/database.php";
require_once "../../Model/returntimeModel.php";
require_once "../../Controller/returnTimeController.php";

use Controller\ReturnTimeController;

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $id = (int) $data['id'];

    $controller = new ReturnTimeController();
    $result = $controller->removeReturnTime($id);

    if ($result) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Return time deleted!'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to delete return time'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing id'
    ]);
}