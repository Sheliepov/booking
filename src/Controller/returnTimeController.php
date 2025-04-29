<?php

namespace Controller;

use Model\ReturnTime;

class ReturnTimeController
{
    private $returnTimeModel;

    public function __construct()
    {
        $this->returnTimeModel = new ReturnTime();
    }

    public function addReturnTime($tripID, $time)
    {
        return $this->returnTimeModel->add($tripID, $time);
    }

    public function getReturnTimes($tripID)
    {
        return $this->returnTimeModel->getByTripID($tripID);
    }

    public function updateReturnTime($id, $time)
    {
        return $this->returnTimeModel->update($id, $time);
    }

    public function removeReturnTime($id)
    {
        return $this->returnTimeModel->delete($id);
    }
}
