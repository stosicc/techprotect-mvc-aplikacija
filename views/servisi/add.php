<?php
$ime_klijenta = $_SESSION['user']['ime'];
$id_klijenta = $_SESSION['user']['id'];
?>

<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Prijava novog servisa</title>
</head>
<body>
    <a href="index.php" class="btn btn-secondary mb-3">← Povratak na početnu</a>

    <h2>Prijava novog servisa</h2>

    <form action="" method="POST" enctype="multipart/form-data">
        <label>Klijent:</label>
        <select name="klijent_id" disabled>
            <option value="<?= $id_klijenta ?>"><?= htmlspecialchars($ime_klijenta) ?></option>
        </select>
        <input type="hidden" name="klijent_id" value="<?= $id_klijenta ?>">

        <br><br>

        <label>Tip sistema:</label>
        <select name="st_tip_sistema_id" required>
            <?php foreach ($tipovi as $tip): ?>
                <option value="<?= $tip['id'] ?>"><?= htmlspecialchars($tip['naziv']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Opis problema:</label><br>
        <textarea name="st_opis_problema" rows="4" cols="50" required></textarea><br><br>

        <label>Datum prijave:</label>
        <input type="date" name="st_datum_prijave" required><br><br>

        <label>Slika (opciono):</label>
        <input type="file" name="st_slika"><br><br>

        <input type="submit" value="Pošalji servisni zahtev">
    </form>
</body>
</html>
