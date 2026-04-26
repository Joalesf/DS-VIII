<?php
$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar libro</title>
    <link rel="stylesheet" href="Assets/Main.css">
</head>
<body>
    <div class="contenedor">
        <div class="encabezado">
            <div>
                <p class="etiqueta">Practica 2 PHP</p>
                <h1>Registrar nuevo libro</h1>
                <p class="texto-suave">Complete el formulario para guardar un libro en la base de datos.</p>
            </div>
            <a class="boton secundario" href="Index.php">Volver al listado</a>
        </div>

        <?php if ($mensaje != '') { ?>
            <div class="mensaje <?php echo $tipo; ?>">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php } ?>

        <div class="tarjeta formulario-tarjeta">
            <form action="Index.php?accion=guardar" method="POST" class="formulario-libro">
                <label>Nombre del libro</label>
                <input type="text" name="nombre"  required>

                <label>Autor</label>
                <input type="text" name="autor" required>

                <label>Categoria</label>
                <input type="text" name="categoria"  required>

                <label>Año</label>
                <input type="number" name="anio" min="1000" max="2099"  required>

                <div class="acciones-formulario">
                    <button type="submit" class="boton">Guardar libro</button>
                    <a class="boton secundario" href="Index.php">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
