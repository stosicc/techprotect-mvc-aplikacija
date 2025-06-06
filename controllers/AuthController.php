<?php
require_once 'config/db.php';

class AuthController {

    public function register() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ime = trim($_POST['ime']);
        $email = trim($_POST['email']);
        $lozinka = $_POST['lozinka'];
        $tip = 'klijent';

        global $conn;

        // Provera da li već postoji korisnik sa datim emailom
        $check = $conn->prepare("SELECT * FROM st_klijenti WHERE st_email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $error = "Korisnik sa tim emailom već postoji.";
            include 'views/register.php';
            return;
        }

        $hash = password_hash($lozinka, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO st_klijenti (st_naziv, st_email, st_lozinka, tip) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $ime, $email, $hash, $tip);
        $stmt->execute();

        header("Location: index.php?page=login");
        exit();
    }

    include 'views/register.php';
}

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $lozinka = $_POST['lozinka'];

            global $conn;
            $stmt = $conn->prepare("SELECT * FROM st_klijenti WHERE st_email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();

            $result = $stmt->get_result();
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();

                if (password_verify($lozinka, $user['st_lozinka'])) {
                    session_start();
                    $_SESSION['user'] = [
                        'id' => $user['st_klijent_id'],
                        'ime' => $user['st_naziv'],
                        'email' => $user['st_email'],
                        'tip' => $user['tip']
                    ];
                    header("Location: index.php");
                    exit();
                } else {
                    $error = "Pogrešna lozinka.";
                }
            } else {
                $error = "Korisnik ne postoji.";
            }
        }

        include 'views/login.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?page=login");
    }
}
