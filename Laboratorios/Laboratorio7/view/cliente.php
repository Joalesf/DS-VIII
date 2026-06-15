<?php
function escapar($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratorio 7 - Cliente SOAP</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>
    <main class="contenedor">
        <section class="panel">
            <div class="encabezado">
                <p>Laboratorio 7</p>
                <h1>Calculadora SOAP</h1>
            </div>

            <form method="post" class="formulario">
                <label for="numero1">Numero 1</label>
                <input
                    id="numero1"
                    name="numero1"
                    type="number"
                    step="any"
                    value="<?php echo escapar($vista['numero1']); ?>"
                    required
                >

                <label for="numero2">Numero 2</label>
                <input
                    id="numero2"
                    name="numero2"
                    type="number"
                    step="any"
                    value="<?php echo escapar($vista['numero2']); ?>"
                    required
                >

                <label for="operacion">Operacion</label>
                <select id="operacion" name="operacion">
                    <?php foreach ($vista['operaciones'] as $valor => $texto): ?>
                        <option value="<?php echo escapar($valor); ?>" <?php echo $vista['operacion'] == $valor ? 'selected' : ''; ?>>
                            <?php echo escapar($texto); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit">Calcular</button>
            </form>

            <?php if ($vista['resultado'] !== null): ?>
                <div class="resultado exito">
                    <span><?php echo escapar($vista['mensaje']); ?></span>
                    <strong><?php echo escapar($vista['resultado']); ?></strong>
                </div>
            <?php endif; ?>

            <?php if ($vista['error'] !== null): ?>
                <div class="resultado error">
                    <span>Error</span>
                    <strong><?php echo escapar($vista['error']); ?></strong>
                </div>
            <?php endif; ?>

            <p class="servicio">Servicio SOAP: <?php echo escapar($vista['servicioUrl']); ?></p>
        </section>
    </main>
</body>
</html>
