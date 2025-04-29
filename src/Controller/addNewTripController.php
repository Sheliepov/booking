<?php

namespace Controller;

use Model\Trip;

class TripController
{
    private $tripModel;

    public function __construct()
    {
        $this->tripModel = new Trip();
    }

    public function saveTrip($tripName, $adultPrice, $childPrice, $infantPrice, $available, $active)
    {
        $success = $this->tripModel->create($tripName, $adultPrice, $childPrice, $infantPrice, $available, $active);

        if ($success) {
            echo json_encode($success);
        } else {
            echo "Failue";
        }
    }

    public function getAllTrips()
    {
        return $this->tripModel->getAll();
    }

    public function removeTrip($id)
    {
        return $this->tripModel->remove($id);
    }

    public function editTrip($id, $adultPrice, $childPrice, $infantPrice)
    {
        return $this->tripModel->update($id, $adultPrice, $childPrice, $infantPrice);
    }

    public function editActive($id, $active)
    {
        return $this->tripModel->updateActive($id, $active);
    }

    public function updateAvailable($tripID, $date, $available)
    {
        return $this->tripModel->updateAvailability($tripID, $date, $available);
    }
}
