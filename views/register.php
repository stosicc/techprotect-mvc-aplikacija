<?php
session_start();
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ime = trim($_POST['ime']);
    $email = trim($_POST['email']);
    $lozinka = $_POST['lozinka'];

    // Provera da li vec postoji korisnik sa tim emailom
    $stmt = $conn->prepare("SELECT * FROM st_klijenti WHERE st_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $rez = $stmt->get_result();

    if ($rez->num_rows > 0) {
        $greska = "Korisnik sa tim emailom vec postoji.";
    } else {
        $hashLozinka = password_hash($lozinka, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO st_klijenti (st_naziv, st_email, st_lozinka, tip) VALUES (?, ?, ?, 'klijent')");
        $stmt->bind_param("sss", $ime, $email, $hashLozinka);
        $stmt->execute();

        $_SESSION['user'] = [
            'st_naziv' => $ime,
            'st_email' => $email,
            'tip' => 'klijent'
        ];

        header("Location: index.php?page=moji-servisi");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Registracija korisnika</title>
</head>
<body>
    <h2>Registracija</h2>

    <?php if (isset($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php?page=register">
        <label for="ime">Ime:</label><br>
        <input type="text" id="ime" name="ime" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="lozinka">Lozinka:</label><br>
        <input type="password" id="lozinka" name="lozinka" required><br><br>

        <input type="submit" value="Registruj se">
    </form>

    <p><a href="index.php?page=login">Već imate nalog? Prijavite se</a></p>
</body>
</html>

