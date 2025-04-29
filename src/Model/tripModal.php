<?php

namespace Model;

use Service\Database;

class Trip
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->conn;
    }

    public function create($tripName, $adultPrice, $childPrice, $infantPrice, $available, $active)
    {
        $stmt = $this->db->prepare("INSERT INTO trips (trip_name, adult_price, child_price, infant_price, available, active) VALUES (?, ?, ?, ?, ?, ?)");

        // Correct types: s = string, d = double, i = integer
        $stmt->bind_param("sdddii", $tripName, $adultPrice, $childPrice, $infantPrice, $available, $active);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAll()
    {
        $result = $this->db->query("SELECT * FROM trips ORDER BY id DESC");
        $trips = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $trips[] = $row;
            }
        }

        return $trips;
    }

    public function remove($id)
    {
        $stmt = $this->db->prepare("DELETE FROM trips WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update($id, $adultPrice, $childPrice, $infantPrice)
    {
        $stmt = $this->db->prepare("UPDATE trips SET adult_price = ?, child_price = ?, infant_price = ? WHERE id = ?");
        $stmt->bind_param("dddi", $adultPrice, $childPrice, $infantPrice, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateActive($id, $active)
    {
        $stmt = $this->db->prepare("UPDATE trips SET active = ? WHERE id = ?");
        $stmt->bind_param("ii", $active, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateAvailability($tripID, $date, $available)
    {
        $stmt = $this->db->prepare("
            UPDATE trips 
            SET available = ? 
            WHERE id = ? 
            AND DATE(created_date) = ?
        ");

        if (!$stmt) {
            throw new \Exception('Failed to prepare statement.');
        }

        $stmt->bind_param('iis', $available, $tripID, $date);

        if ($stmt->execute()) {
            return true;
        } else {
            throw new \Exception('Failed to update availability.');
        }
    }
}
