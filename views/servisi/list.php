<a href="index.php" class="btn btn-secondary mb-3">← Povratak na početnu</a>
<h2>Svi servisi (TechProtect)</h2>

<form method="get" action="index.php">
    <input type="hidden" name="page" value="admin-servisi">
    <label>Status:
        <select name="status">
            <option value="">-- Svi --</option>
            <?php foreach ($statusi as $status): ?>
                <option value="<?= $status ?>" <?= ($_GET['status'] ?? '') === $status ? 'selected' : '' ?>>
                    <?= htmlspecialchars($status) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>
    <label>Tip sistema:
        <select name="tip_sistema">
            <option value="">-- Svi --</option>
            <?php while ($row = $tipovi->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>" <?= ($_GET['tip_sistema'] ?? '') == $row['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($row['naziv']) ?>
                </option>
            <?php endwhile; ?>
        </select>
    </label>
    <button type="submit">Filtriraj</button>
</form>

<br>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Klijent</th>
        <th>Tip sistema</th>
        <th>Opis</th>
        <th>Status</th>
        <th>Datum prijave</th>
        <th>Datum završetka</th>
        <th>Slika</th>
        <th>Akcija</th>
    </tr>

    <?php while ($s = $servisi->fetch_assoc()): ?>
        <tr>
            <td><?= $s['st_id'] ?></td>
            <td><?= htmlspecialchars($s['klijent_naziv']) ?></td>
            <td><?= htmlspecialchars($s['sistem_naziv']) ?></td>
            <td><?= nl2br(htmlspecialchars($s['st_opis_problema'])) ?></td>
            <td><?= htmlspecialchars($s['st_status']) ?></td>
            <td><?= htmlspecialchars($s['st_datum_prijave']) ?></td>
            <td><?= $s['st_datum_zavrsetka'] ?? '-' ?></td>
            <td>
                <?php if (!empty($s['st_slika'])): ?>
                    <img src="uploads/<?= htmlspecialchars($s['st_slika']) ?>" width="100">
                <?php else: ?>
                    —
                <?php endif; ?>
            </td>
            <td><a href="index.php?page=izmeni-status&id=<?= $s['st_id'] ?>">Izmeni</a></td>
        </tr>
    <?php endwhile; ?>
</table>
