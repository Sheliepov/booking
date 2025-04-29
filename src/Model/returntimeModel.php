<?php

namespace Model;

use Service\Database;

class ReturnTime
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->conn;
    }

    public function add($tripID, $time)
    {
        $stmt = $this->db->prepare("INSERT INTO return_time (trip_id, return_time) VALUES (?, ?)");
        $stmt->bind_param("is", $tripID, $time);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
    public function getByTripID($tripID)
    {
        $stmt = $this->db->prepare("SELECT id, return_time FROM return_time WHERE trip_id = ?");
        $stmt->bind_param("i", $tripID);
        $stmt->execute();

        $result = $stmt->get_result();
        $returnTimes = [];

        while ($row = $result->fetch_assoc()) {
            $returnTimes[] = $row;
        }

        $stmt->close();

        return $returnTimes;
    }

    public function update($id, $time)
    {
        $stmt = $this->db->prepare("UPDATE return_time SET return_time = ? WHERE id = ?");
        $stmt->bind_param("si", $time, $id);

        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM return_time WHERE id = ?");
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}
