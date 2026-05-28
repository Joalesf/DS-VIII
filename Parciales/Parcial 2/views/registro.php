<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(isset($titulo) ? $titulo : 'Crear cuenta') ?></title>
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

    <main class="auth-background register-background">
        <section class="main-content page-section auth-content">
            <div class="page-title">
                <p class="eyebrow">Aspirantes</p>
                <h1>Crear cuenta</h1>
                <p>Ingresa un usuario y una contrasena segura para iniciar tu solicitud.</p>
            </div>

            <?php if (!empty($errores)): ?>
                <div class="alert alert-error">
                    <strong>Revisa estos datos:</strong>
                    <ul>
                        <?php foreach ($errores as $error): ?>
                            <li><?= e($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (!empty($mensaje ?? '')): ?>
                <div class="alert alert-success">
                    <?= e($mensaje ?? '') ?>
                </div>
                <script>
                    setTimeout(() => {
                        window.location.href = '<?= e(url('login')) ?>';
                    }, 2500);
                </script>
            <?php endif; ?>

            <form class="form-panel" action="<?= e(url('registro')) ?>" method="POST" autocomplete="off">
                <div class="form-field">
                    <label for="usuario">Usuario</label>
                    <input
                        type="text"
                        id="usuario"
                        name="usuario"
                        value="<?= e($usuario ?? '') ?>"
                        maxlength="30"
                        required>
                </div>

                <div class="form-field">
                    <label for="password">Contrasena</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        minlength="15"
                        required>
                </div>

                <div class="form-field">
                    <label for="confirmar_password">Confirmar contrasena</label>
                    <input
                        type="password"
                        id="confirmar_password"
                        name="confirmar_password"
                        minlength="15"
                        required>
                </div>

                <button class="primary-action" type="submit">Crear cuenta</button>
            </form>
        </section>
    </main>
</body>

</html>