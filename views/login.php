<?php
session_start();
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $lozinka = $_POST['lozinka'];

    $stmt = $conn->prepare("SELECT * FROM st_klijenti WHERE st_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $rez = $stmt->get_result();

    if ($rez->num_rows === 1) {
        $korisnik = $rez->fetch_assoc();

        if (password_verify($lozinka, $korisnik['st_lozinka'])) {
            
            $_SESSION['user'] = [
                'id' => $korisnik['st_klijent_id'],
                'ime' => $korisnik['st_naziv'],
                'email' => $korisnik['st_email'],
                'tip' => $korisnik['tip']
            ];


            $_SESSION['email'] = $korisnik['st_email'];

           
            if ($korisnik['tip'] === 'admin') {
                header("Location: index.php?page=admin-servisi");
            } else {
                header("Location: index.php?page=moji-servisi");
            }
            exit;
        } else {
            $greska = "Pogrešna lozinka.";
        }
    } else {
        $greska = "Korisnik nije pronađen.";
    }
}
?>

<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Prijava</title>
</head>
<body>
    <h2>Prijava</h2>

    <?php if (isset($greska)): ?>
        <p style="color:red;"><?= htmlspecialchars($greska) ?></p>
    <?php endif; ?>

    <form method="post">
        Email: <input type="email" name="email" required><br><br>
        Lozinka: <input type="password" name="lozinka" required><br><br>
        <input type="submit" value="Prijavi se">
    </form>

    <p><a href="index.php?page=register">Nemate nalog? Registrujte se</a></p>
</body>
</html>
