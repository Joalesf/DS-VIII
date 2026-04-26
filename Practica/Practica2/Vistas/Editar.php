<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar libro</title>
    <link rel="stylesheet" href="Assets/Main.css">
</head>
<body>
    <div class="contenedor">
        <div class="encabezado">
            <div>
                <p class="etiqueta">Practica 2 PHP</p>
                <h1>Editar libro</h1>
                <p class="texto-suave">Modifique los datos necesarios y guarde los cambios.</p>
            </div>
            <a class="boton secundario" href="Index.php">Volver al listado</a>
        </div>

        <div class="tarjeta formulario-tarjeta">
            <form action="Index.php?accion=actualizar" method="POST" class="formulario-libro">
                <input type="hidden" name="id" value="<?php echo $libro['id']; ?>">

                <label>Nombre del libro</label>
                <input type="text" name="nombre" value="<?php echo htmlspecialchars($libro['nombre']); ?>" required>

                <label>Autor</label>
                <input type="text" name="autor" value="<?php echo htmlspecialchars($libro['autor']); ?>" required>

                <label>Categoria</label>
                <input type="text" name="categoria" value="<?php echo htmlspecialchars($libro['categoria']); ?>" required>

                <label>Año</label>
                <input type="number" name="anio" min="1000" max="2099" value="<?php echo htmlspecialchars($libro['anio']); ?>" required>

                <div class="acciones-formulario">
                    <button type="submit" class="boton">Actualizar libro</button>
                    <a class="boton secundario" href="Index.php">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
