<?php
require_once 'models/Servis.php';

class ServisiController {
    public function unos() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $klijent_id = $_SESSION['user']['id'];
            $tip_id = $_POST['st_tip_sistema_id'];
            $opis = $_POST['st_opis_problema'];
            $datum = $_POST['st_datum_prijave'];
            $status = 'U funkciji';
            $komentar = '';
            $slika = '';

            if (isset($_FILES['st_slika']) && $_FILES['st_slika']['error'] === UPLOAD_ERR_OK) {
                $tmp_name = $_FILES['st_slika']['tmp_name'];
                $original_name = basename($_FILES['st_slika']['name']);
                $ext = pathinfo($original_name, PATHINFO_EXTENSION);
                $slika = uniqid('slika_', true) . '.' . $ext;
                move_uploaded_file($tmp_name, 'uploads/' . $slika);
            }

            Servis::create($klijent_id, $tip_id, $opis, $slika, $status, $komentar, $datum);

            if ($_SESSION['user']['tip'] === 'admin') {
                header("Location: index.php?page=admin-servisi");
            } else {
                header("Location: index.php?page=moji-servisi");
            }
            exit();
        } else {
            $tipovi = Servis::getAllSystemTypes();
            include 'views/servisi/add.php';
        }
    }

    public function userList() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=login");
            exit();
        }

        global $conn;
        $klijent_id = $_SESSION['user']['id'];

        $stmt = $conn->prepare("
            SELECT s.*, t.st_naziv AS tip_naziv 
            FROM st_servisi s 
            LEFT JOIN st_tipovi_sistema t ON s.st_tip_sistema = t.st_tip_sistema_id
            WHERE s.st_klijent = ?
            ORDER BY s.st_datum_prijave DESC
        ");
        $stmt->bind_param("i", $klijent_id);
        $stmt->execute();
        $rezultat = $stmt->get_result();
        $servisi = $rezultat->fetch_all(MYSQLI_ASSOC);

        include 'views/servisi/moji-servisi.php';
    }

    public function adminList() {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['tip'] !== 'admin') {
            header("Location: index.php");
            exit();
        }

        $status = $_GET['status'] ?? '';
        $tip_sistema = $_GET['tip_sistema'] ?? '';

        $servisi = Servis::getFiltered($status, $tip_sistema);
        $tipovi = Servis::getAllSystemTypes();
        $statusi = Servis::getAllStatuses();

        include 'views/servisi/list.php';
    }

    public function updateStatus() {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['tip'] !== 'admin') {
            header("Location: index.php");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $status = $_POST['status'];
            $komentar = $_POST['st_komentar_servisera'] ?? null;

            if ($status === 'Završeno') {
                Servis::setDateFinished($id);
            }

            Servis::updateStatus($id, $status, $komentar);
            header("Location: index.php?page=admin-servisi");
        } else {
            if (!isset($_GET['id'])) {
                echo "Greška: nedostaje ID.";
                return;
            }

            $id = intval($_GET['id']);
            include 'views/servisi/edit.php';
        }
    }

    public function statistika() {
        session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['tip'] !== 'admin') {
            header("Location: index.php");
            exit();
        }

        $ukupno = Servis::countAll();
        $poStatusu = Servis::countByStatus();
        $poTipu = Servis::countBySystemType();

        include 'views/servisi/statistika.php';
    }
}
