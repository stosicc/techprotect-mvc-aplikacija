<?php

class Servis {
    public static function create($klijent_id, $tip_sistema, $opis, $slika, $status, $komentar, $datum) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO st_servisi 
            (st_klijent, st_tip_sistema, st_opis_problema, st_slika, st_status, st_komentar_servisera, st_datum_prijave) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisssss", $klijent_id, $tip_sistema, $opis, $slika, $status, $komentar, $datum);
        $stmt->execute();
    }

    public static function getAll() {
        global $conn;
        $sql = "SELECT * FROM st_servisi ORDER BY st_datum_prijave DESC";
        return $conn->query($sql);
    }

    public static function getFiltered($status = '', $tip_sistema = '') {
        global $conn;

        $sql = "
            SELECT s.*, 
                   k.st_naziv AS klijent_naziv, 
                   t.st_naziv AS sistem_naziv
            FROM st_servisi s
            LEFT JOIN st_klijenti k ON s.st_klijent = k.st_klijent_id
            LEFT JOIN st_tipovi_sistema t ON s.st_tip_sistema = t.st_tip_sistema_id
            WHERE 1=1
        ";

        if (!empty($status)) {
            $sql .= " AND s.st_status = '" . $conn->real_escape_string($status) . "'";
        }

        if (!empty($tip_sistema)) {
            $sql .= " AND s.st_tip_sistema = '" . $conn->real_escape_string($tip_sistema) . "'";
        }

        $sql .= " ORDER BY s.st_datum_prijave DESC";
        return $conn->query($sql);
    }

    public static function getAllStatuses() {
        global $conn;
        $res = $conn->query("SELECT DISTINCT st_status FROM st_servisi ORDER BY st_status ASC");
        $statusi = [];
        while ($row = $res->fetch_assoc()) {
            $statusi[] = $row['st_status'];
        }
        return $statusi;
    }

    public static function updateStatus($id, $status, $komentar) {
        global $conn;
        $stmt = $conn->prepare("UPDATE st_servisi SET st_status = ?, st_komentar_servisera = ? WHERE st_id = ?");
        $stmt->bind_param("ssi", $status, $komentar, $id);
        $stmt->execute();
    }

    public static function setDateFinished($id) {
        global $conn;
        $stmt = $conn->prepare("UPDATE st_servisi SET st_datum_zavrsetka = NOW() WHERE st_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    public static function getAllClients() {
        global $conn;
        return $conn->query("SELECT st_klijent_id AS id, st_naziv AS naziv FROM st_klijenti ORDER BY st_naziv ASC");
    }

    public static function getAllSystemTypes() {
        global $conn;
        $sql = "SELECT st_tip_sistema_id AS id, st_naziv AS naziv FROM st_tipovi_sistema ORDER BY st_naziv ASC";
        return $conn->query($sql);
    }

    public static function countAll() {
        global $conn;
        $result = $conn->query("SELECT COUNT(*) AS ukupno FROM st_servisi");
        return $result->fetch_assoc()['ukupno'];
    }

    public static function countByStatus() {
        global $conn;
        return $conn->query("SELECT st_status, COUNT(*) AS broj FROM st_servisi GROUP BY st_status");
    }

    public static function countBySystemType() {
        global $conn;
        $sql = "SELECT t.st_naziv AS sistem_naziv, COUNT(*) AS broj
                FROM st_servisi s
                LEFT JOIN st_tipovi_sistema t ON s.st_tip_sistema = t.st_tip_sistema_id
                GROUP BY s.st_tip_sistema";
        return $conn->query($sql);
    }
}
