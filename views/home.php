<?php require_once 'views/layout.php'; ?>

<div class="container py-5 text-center">
    <h1 class="display-4">TechProtect dobrodošli</h1>
    <p class="lead">Jednostavno prijavite kvar i pratite status servisa u realnom vremenu.</p>

    <?php if (isset($_SESSION['user'])): ?>
        <div class="mt-4 text-start mx-auto" style="max-width: 400px;">
            <h4>Zdravo, <strong><?= htmlspecialchars($_SESSION['user']['ime'] ?? 'Korisnik') ?></strong>!</h4>
            <div class="d-grid gap-2 mt-3">
                <a href="index.php?page=prijavi-servis" class="btn btn-outline-primary">Prijavi novi servis</a>
                <a href="index.php?page=moji-servisi" class="btn btn-outline-secondary">Moji servisi</a>
                <?php if ($_SESSION['user']['tip'] === 'admin'): ?>
                    <a href="index.php?page=admin-servisi" class="btn btn-outline-warning">Admin panel</a>
                <?php endif; ?>
                <a href="index.php?page=logout" class="btn btn-outline-danger">Odjavi se</a>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info mt-4">
            <p>Da biste koristili aplikaciju, prijavite se ili registrujte.</p>
            <a href="index.php?page=login" class="btn btn-primary">Prijava</a>
            <a href="index.php?page=register" class="btn btn-secondary">Registracija</a>
        </div>
    <?php endif; ?>
</div>