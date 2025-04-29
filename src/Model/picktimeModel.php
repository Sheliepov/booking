<?php

namespace Model;

use Service\Database;

class PickTime
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->conn;
    }

    public function add($tripID, $time)
    {
        $stmt = $this->db->prepare("INSERT INTO pick_time (trip_id, pick_time) VALUES (?, ?)");
        $stmt->bind_param("is", $tripID, $time);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getByTripID($tripID)
    {
        $stmt = $this->db->prepare("SELECT id, pick_time FROM pick_time WHERE trip_id = ?");
        $stmt->bind_param("i", $tripID);
        $stmt->execute();

        $result = $stmt->get_result();
        $pickTimes = [];

        while ($row = $result->fetch_assoc()) {
            $pickTimes[] = $row;
        }

        $stmt->close();

        return $pickTimes;
    }

    public function update($id, $time)
    {
        $stmt = $this->db->prepare("UPDATE pick_time SET pick_time = ? WHERE id = ?");
        $stmt->bind_param("si", $time, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM pick_time WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}