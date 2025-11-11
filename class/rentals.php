<?php
require_once 'config/config.php';
require_once 'equipments.php';
require_once 'members.php';

class Rentals {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    // create data rental
    public function createRental($equipment_id, $member_id) {
        // cek stok alat dulu
        $stmt = $this->db->prepare("SELECT stock FROM equipments WHERE id = ?");
        $stmt->execute([$equipment_id]);
        $equipmentData = $stmt->fetch();

        if ($equipmentData && $equipmentData['stock'] > 0) {
            // kurangin stok alat
            $equipment = new Equipments();
            $equipment->updateStock($equipment_id, $equipmentData['stock'] - 1);

            // nambah data rental
            $stmt = $this->db->prepare("
                INSERT INTO rentals (equipment_id, member_id, rent_date)
                VALUES (?, ?, CURDATE())
            ");
            return $stmt->execute([$equipment_id, $member_id]);
        }

        return false; // stok kosong
    }

    // read data rental
    public function getAllRentals() {
        $stmt = $this->db->prepare("
            SELECT rentals.*, 
                   equipments.name AS equipment_name, 
                   members.name AS member_name
            FROM rentals
            JOIN equipments ON rentals.equipment_id = equipments.id
            JOIN members ON rentals.member_id = members.id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ngambil data rental berdasarkan id
    public function getRentalById($id) {
        $stmt = $this->db->prepare("
            SELECT rentals.*, 
                   equipments.name AS equipment_name, 
                   members.name AS member_name
            FROM rentals
            JOIN equipments ON rentals.equipment_id = equipments.id
            JOIN members ON rentals.member_id = members.id
            WHERE rentals.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // update pengembalian alat
    public function returnEquipment($rental_id) {
        // amnbil data rental
        $stmt = $this->db->prepare("SELECT equipment_id FROM rentals WHERE id = ?");
        $stmt->execute([$rental_id]);
        $rental = $stmt->fetch();

        if ($rental) {
            // ambil stok alat
            $stmt = $this->db->prepare("SELECT stock FROM equipments WHERE id = ?");
            $stmt->execute([$rental['equipment_id']]);
            $equipmentData = $stmt->fetch();

            // update stok alat
            $equipment = new Equipments();
            $equipment->updateStock($rental['equipment_id'], $equipmentData['stock'] + 1);

            // update tanggal pengembalian
            $stmt = $this->db->prepare("UPDATE rentals SET return_date = CURDATE() WHERE id = ?");
            return $stmt->execute([$rental_id]);
        }

        return false;
    }

    // update data rental
    public function updateRental($id, $equipment_id, $member_id, $rent_date, $return_date = null) {
        $stmt = $this->db->prepare("
            UPDATE rentals 
            SET equipment_id = ?, member_id = ?, rent_date = ?, return_date = ?
            WHERE id = ?
        ");
        return $stmt->execute([$equipment_id, $member_id, $rent_date, $return_date, $id]);
    }

    // delete data rental
    public function deleteRental($id) {
        // ambil dulu equipment_id biar stok bisa dikembalikan
        $stmt = $this->db->prepare("SELECT equipment_id FROM rentals WHERE id = ?");
        $stmt->execute([$id]);
        $rental = $stmt->fetch();

        if ($rental) {
            // ambil stok alat
            $stmt = $this->db->prepare("SELECT stock FROM equipments WHERE id = ?");
            $stmt->execute([$rental['equipment_id']]);
            $equipmentData = $stmt->fetch();

            // tambahkan stok kembali
            $equipment = new Equipments();
            $equipment->updateStock($rental['equipment_id'], $equipmentData['stock'] + 1);
        }

        // hapus data rental
        $stmt = $this->db->prepare("DELETE FROM rentals WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>