<h2>Izmena statusa servisa</h2>

<form method="POST" action="index.php?page=izmeni-status">
    <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id']) ?>">

    <label>Novi status:</label>
    <select name="status" required>
        <?php
        $statusi = ['U funkciji', 'U kvaru', 'U toku', 'Završeno', 'Zamenjeno'];
        foreach ($statusi as $s) {
            $selected = ($s === $servis['st_status']) ? 'selected' : '';
            echo "<option value=\"$s\" $selected>$s</option>";
        }
        ?>
    </select><br><br>

    <label>Komentar servisera:</label><br>
    <textarea name="st_komentar_servisera" rows="4" cols="50"><?= htmlspecialchars($servis['st_komentar_servisera'] ?? '') ?></textarea><br><br>

    <input type="submit" value="Sačuvaj promene">
</form>
