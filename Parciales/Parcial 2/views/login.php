<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(isset($titulo) ? $titulo : 'Iniciar sesion') ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <header class="site-header">
        <a class="brand" href="<?= e(url('inicio')) ?>">Sistema RH</a>
        <nav class="nav">
            <a href="<?= e(url('inicio')) ?>">Inicio</a>
            <a href="<?= e(url('registro')) ?>">Crear cuenta</a>
            <a class="button-link" href="<?= e(url('login')) ?>">Iniciar sesion</a>
        </nav>
    </header>

    <main class="auth-background login-background">
        <section class="main-content page-section auth-content">
            <div class="page-title">
                <p class="eyebrow">Acceso</p>
                <h1>Iniciar sesion</h1>
                <p>Ingresa con tu usuario y contrasena para continuar con tu solicitud.</p>
            </div>

            <?php if (!empty($errores)): ?>
                <div class="alert alert-error">
                    <strong>No se pudo iniciar sesion:</strong>
                    <ul>
                        <?php foreach ($errores as $error): ?>
                            <li><?= e($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form class="form-panel" action="<?= e(url('login')) ?>" method="POST" autocomplete="off">
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
                        required>
                </div>

                <button class="primary-action" type="submit">Entrar</button>
            </form>
        </section>
    </main>
</body>

</html>