<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(isset($titulo) ? $titulo : 'Panel RH') ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <header class="site-header">
        <a class="brand" href="<?= e(url('inicio')) ?>">Sistema RH</a>
        <nav class="nav">
            <a href="<?= e(url('rh')) ?>">Solicitudes</a>
            <a class="button-link" href="<?= e(url('logout')) ?>">Cerrar sesion</a>
        </nav>
    </header>

    <main class="main-content page-section">
        <div class="page-title">
            <p class="eyebrow">Recursos Humanos</p>
            <h1>Solicitudes de empleo</h1>
            <p>Revisa los aspirantes registrados y cambia el estado de cada solicitud.</p>
        </div>

        <?php if (!empty($errores)): ?>
            <div class="alert alert-error">
                <strong>No se pudo actualizar:</strong>
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

        <?php if (empty($solicitudes ?? [])): ?>
            <div class="info-panel">
                <strong>Sin solicitudes</strong>
                <p>Todavia no hay aspirantes con informacion registrada.</p>
            </div>
        <?php else: ?>
            <div class="table-panel">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Aspirante</th>
                            <th>Cedula/Pasaporte</th>
                            <th>Datos</th>
                            <th>Contacto</th>
                            <th>Estado</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (($solicitudes ?? []) as $solicitud): ?>
                            <tr>
                                <td>
                                    <strong><?= e($solicitud['nombre'] . ' ' . $solicitud['apellido']) ?></strong>
                                    <span><?= e($solicitud['usuario']) ?></span>
                                </td>
                                <td><?= e($solicitud['cedula_pasaporte']) ?></td>
                                <td>
                                    <span>Genero: <?= e($solicitud['genero']) ?></span>
                                    <span>Estado civil: <?= e($solicitud['estado_civil'] ?: 'No indicado') ?></span>
                                    <span>Sangre: <?= e($solicitud['tipo_sangre'] ?: 'No indicado') ?></span>
                                    <span>Nacimiento: <?= e($solicitud['fecha_nacimiento']) ?></span>
                                    <span>Nacionalidad: <?= e($solicitud['nacionalidad']) ?></span>
                                    <span>Residencia: <?= e($solicitud['residencia']) ?></span>
                                </td>
                                <td>
                                    <span><?= e($solicitud['telefono']) ?></span>
                                    <span><?= e($solicitud['correo']) ?></span>
                                </td>
                                <td>
                                    <span class="status-pill table-status"><?= e($solicitud['estado_solicitud']) ?></span>
                                </td>
                                <td>
                                    <form class="inline-form" action="<?= e(url('rh')) ?>" method="POST">
                                        <input type="hidden" name="solicitud_id" value="<?= e((string) $solicitud['id']) ?>">
                                        <select name="estado_solicitud" required>
                                            <option value="no revisado" <?= $solicitud['estado_solicitud'] === 'no revisado' ? 'selected' : '' ?>>No revisado</option>
                                            <option value="considerado" <?= $solicitud['estado_solicitud'] === 'considerado' ? 'selected' : '' ?>>Considerado</option>
                                            <option value="no considerado" <?= $solicitud['estado_solicitud'] === 'no considerado' ? 'selected' : '' ?>>No considerado</option>
                                        </select>
                                        <button class="secondary-action" type="submit">Actualizar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </main>
</body>

</html>