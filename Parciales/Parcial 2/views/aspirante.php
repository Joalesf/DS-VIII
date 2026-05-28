<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(isset($titulo) ? $titulo : 'Mi solicitud') ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <header class="site-header">
        <a class="brand" href="<?= e(url('inicio')) ?>">Sistema RH</a>
        <nav class="nav">
            <a href="<?= e(url('aspirante')) ?>">Mi solicitud</a>
            <a class="button-link" href="<?= e(url('logout')) ?>">Cerrar sesion</a>
        </nav>
    </header>

    <main class="aspirante-background">
        <section class="main-content page-section">
            <div class="page-title">
                <p class="eyebrow">Aspirante</p>
                <h1>Mi solicitud</h1>
                <p>Completa o actualiza tus datos personales para Recursos Humanos.</p>
                <span class="status-pill">Estado: <?= e($estadoSolicitud ?? 'no revisado') ?></span>
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
            <?php endif; ?>

            <form class="form-panel form-wide" action="<?= e(url('aspirante')) ?>" method="POST" autocomplete="off">
                <div class="form-grid">
                    <div class="form-field">
                        <label for="cedula_pasaporte">Cedula o pasaporte</label>
                        <input
                            type="text"
                            id="cedula_pasaporte"
                            name="cedula_pasaporte"
                            value="<?= e(isset($datos['cedula_pasaporte']) ? $datos['cedula_pasaporte'] : '') ?>"
                            maxlength="30"
                            required>
                    </div>

                    <div class="form-field">
                        <label for="nombre">Nombre</label>
                        <input
                            type="text"
                            id="nombre"
                            name="nombre"
                            value="<?= e(isset($datos['nombre']) ? $datos['nombre'] : '') ?>"
                            maxlength="80"
                            required>
                    </div>

                    <div class="form-field">
                        <label for="apellido">Apellido</label>
                        <input
                            type="text"
                            id="apellido"
                            name="apellido"
                            value="<?= e(isset($datos['apellido']) ? $datos['apellido'] : '') ?>"
                            maxlength="80"
                            required>
                    </div>

                    <div class="form-field">
                        <label for="estado_civil">Estado civil</label>
                        <select id="estado_civil" name="estado_civil">
                            <option value="">Seleccione</option>
                            <option value="soltero" <?= isset($datos['estado_civil']) && $datos['estado_civil'] === 'soltero' ? 'selected' : '' ?>>Soltero</option>
                            <option value="casado" <?= isset($datos['estado_civil']) && $datos['estado_civil'] === 'casado' ? 'selected' : '' ?>>Casado</option>
                            <option value="divorciado" <?= isset($datos['estado_civil']) && $datos['estado_civil'] === 'divorciado' ? 'selected' : '' ?>>Divorciado</option>
                            <option value="viudo" <?= isset($datos['estado_civil']) && $datos['estado_civil'] === 'viudo' ? 'selected' : '' ?>>Viudo</option>
                            <option value="union libre" <?= isset($datos['estado_civil']) && $datos['estado_civil'] === 'union libre' ? 'selected' : '' ?>>Union libre</option>
                        </select>
                    </div>

                    <div class="form-field">
                        <label for="genero">Genero</label>
                        <select id="genero" name="genero" required>
                            <option value="">Seleccione</option>
                            <option value="femenino" <?= isset($datos['genero']) && $datos['genero'] === 'femenino' ? 'selected' : '' ?>>Femenino</option>
                            <option value="masculino" <?= isset($datos['genero']) && $datos['genero'] === 'masculino' ? 'selected' : '' ?>>Masculino</option>
                            <option value="otro" <?= isset($datos['genero']) && $datos['genero'] === 'otro' ? 'selected' : '' ?>>Otro</option>
                        </select>
                    </div>

                    <div class="form-field">
                        <label for="tipo_sangre">Tipo de sangre</label>
                        <select id="tipo_sangre" name="tipo_sangre">
                            <option value="">Seleccione</option>
                            <option value="A+" <?= isset($datos['tipo_sangre']) && $datos['tipo_sangre'] === 'A+' ? 'selected' : '' ?>>A+</option>
                            <option value="A-" <?= isset($datos['tipo_sangre']) && $datos['tipo_sangre'] === 'A-' ? 'selected' : '' ?>>A-</option>
                            <option value="B+" <?= isset($datos['tipo_sangre']) && $datos['tipo_sangre'] === 'B+' ? 'selected' : '' ?>>B+</option>
                            <option value="B-" <?= isset($datos['tipo_sangre']) && $datos['tipo_sangre'] === 'B-' ? 'selected' : '' ?>>B-</option>
                            <option value="AB+" <?= isset($datos['tipo_sangre']) && $datos['tipo_sangre'] === 'AB+' ? 'selected' : '' ?>>AB+</option>
                            <option value="AB-" <?= isset($datos['tipo_sangre']) && $datos['tipo_sangre'] === 'AB-' ? 'selected' : '' ?>>AB-</option>
                            <option value="O+" <?= isset($datos['tipo_sangre']) && $datos['tipo_sangre'] === 'O+' ? 'selected' : '' ?>>O+</option>
                            <option value="O-" <?= isset($datos['tipo_sangre']) && $datos['tipo_sangre'] === 'O-' ? 'selected' : '' ?>>O-</option>
                        </select>
                    </div>

                    <div class="form-field">
                        <label for="fecha_nacimiento">Fecha de nacimiento</label>
                        <input
                            type="date"
                            id="fecha_nacimiento"
                            name="fecha_nacimiento"
                            value="<?= e(isset($datos['fecha_nacimiento']) ? $datos['fecha_nacimiento'] : '') ?>"
                            required>
                    </div>

                    <div class="form-field">
                        <label for="nacionalidad">Nacionalidad</label>
                        <input
                            type="text"
                            id="nacionalidad"
                            name="nacionalidad"
                            value="<?= e(isset($datos['nacionalidad']) ? $datos['nacionalidad'] : '') ?>"
                            maxlength="80"
                            required>
                    </div>

                    <div class="form-field">
                        <label for="telefono">Telefono</label>
                        <input
                            type="tel"
                            id="telefono"
                            name="telefono"
                            value="<?= e(isset($datos['telefono']) ? $datos['telefono'] : '') ?>"
                            maxlength="30"
                            required>
                    </div>

                    <div class="form-field">
                        <label for="correo">Correo electronico</label>
                        <input
                            type="email"
                            id="correo"
                            name="correo"
                            value="<?= e(isset($datos['correo']) ? $datos['correo'] : '') ?>"
                            maxlength="120"
                            required>
                    </div>
                </div>

                <div class="form-field">
                    <label for="residencia">Residencia</label>
                    <textarea
                        id="residencia"
                        name="residencia"
                        maxlength="180"
                        required><?= e(isset($datos['residencia']) ? $datos['residencia'] : '') ?></textarea>
                </div>

                <button class="primary-action" type="submit">Guardar informacion</button>
            </form>
        </section>
    </main>
</body>

</html>