<a href="index.php" class="btn btn-secondary mb-3">← Povratak na početnu</a>
<h2>Moje servisne prijave</h2>

<?php if (empty($servisi)): ?>
    <p>Nemate nijednu servisnu prijavu.</p>
<?php else: ?>
    <table border="1" cellpadding="8">
        <tr>
            <th>Tip sistema</th>
            <th>Opis problema</th>
            <th>Status</th>
            <th>Datum prijave</th>
        </tr>
        <?php foreach ($servisi as $servis): ?>
            <tr>
                <td><?= htmlspecialchars($servis['tip_naziv']) ?></td>
                <td><?= htmlspecialchars($servis['st_opis_problema']) ?></td>
                <td><?= htmlspecialchars($servis['st_status']) ?></td>
                <td><?= htmlspecialchars($servis['st_datum_prijave']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
