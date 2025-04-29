<?php

namespace Controller;

use Model\PickTime;

class PickTimeController
{
    private $pickTimeModel;

    public function __construct()
    {
        $this->pickTimeModel = new PickTime();
    }

    public function addPickTime($tripID, $time)
    {
        return $this->pickTimeModel->add($tripID, $time);
    }

    public function getPickTimes($tripID)
    {
        return $this->pickTimeModel->getByTripID($tripID);
    }

    public function updatePickTime($id, $time)
    {
        return $this->pickTimeModel->update($id, $time);
    }

    public function removePickTime($id)
    {
        return $this->pickTimeModel->delete($id);
    }
}