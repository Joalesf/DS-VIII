<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(isset($titulo) ? $titulo : 'Sistema RH') ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <header class="site-header">
        <a class="brand" href="<?= e(url('inicio')) ?>">Sistema RH</a>
        <nav class="nav">
            <a href="<?= e(url('inicio')) ?>">Inicio</a>
            <?php if (estaLogueado()): ?>
                <?php if (esRh()): ?>
                    <a href="<?= e(url('rh')) ?>">Solicitudes</a>
                <?php else: ?>
                    <a href="<?= e(url('aspirante')) ?>">Mi solicitud</a>
                <?php endif; ?>
                <a class="button-link" href="<?= e(url('logout')) ?>">Cerrar sesion</a>
            <?php else: ?>
                <a href="<?= e(url('registro')) ?>">Crear cuenta</a>
                <a class="button-link" href="<?= e(url('login')) ?>">Iniciar sesion</a>
            <?php endif; ?>
        </nav>
    </header>
    <main class="main-content">
        <section class="hero">
            <div class="hero-content">
                <p class="eyebrow">Recursos Humanos</p>
                <h1>Registro de aspirantes</h1>
                <p class="hero-text">
                    Accede para completar tu informacion personal y mantener actualizada tu solicitud de empleo.
                </p>
                <div class="actions">
                    <?php if (estaLogueado()): ?>
                        <?php if (esRh()): ?>
                            <a class="primary-action" href="<?= e(url('rh')) ?>">Ver solicitudes</a>
                        <?php else: ?>
                            <a class="primary-action" href="<?= e(url('aspirante')) ?>">Ver mi solicitud</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a class="primary-action" href="<?= e(url('registro')) ?>">Crear cuenta</a>
                        <a class="secondary-action" href="<?= e(url('login')) ?>">Iniciar sesion</a>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>
</body>

</html>