<?php
$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca de libros</title>
    <link rel="stylesheet" href="Assets/Main.css">
    <script src="Assets/Javascript.js" defer></script>
</head>
<body>
    <div class="contenedor">
        <div class="encabezado">
            <div>
                <p class="etiqueta">Practica 2 PHP</p>
                <h1>Administrador de libros</h1>
                <p class="texto-suave">Creado por Jose Sánchez, Richard Rodriguez y Edgar Rosario</p>
            </div>
            <a class="boton" href="Index.php?accion=crear">Nuevo libro</a>
        </div>

        <?php if ($mensaje != '') { ?>
            <div class="mensaje <?php echo $tipo; ?>">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php } ?>

        <div class="resumen">
            <div class="tarjeta mini">
                <span class="mini-titulo">Total de libros</span>
                <strong><?php echo count($libros); ?></strong>
            </div>
            <div class="tarjeta mini">
                <span class="mini-titulo">Estado</span>
                <strong>Activo</strong>
            </div>
        </div>

        <div class="tarjeta tabla-tarjeta">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Autor</th>
                        <th>Categoria</th>
                        <th>Año</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($libros) > 0) { ?>
                        <?php foreach ($libros as $libro) { ?>
                            <tr>
                                <td><?php echo $libro['id']; ?></td>
                                <td><?php echo htmlspecialchars($libro['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($libro['autor']); ?></td>
                                <td><?php echo htmlspecialchars($libro['categoria']); ?></td>
                                <td><?php echo htmlspecialchars($libro['anio']); ?></td>
                                <td class="acciones-tabla">
                                    <a class="link-accion editar" href="Index.php?accion=editar&id=<?php echo $libro['id']; ?>">Editar</a>
                                    <a class="link-accion eliminar" href="Index.php?accion=eliminar&id=<?php echo $libro['id']; ?>" onclick="return confirmarEliminacion()">Eliminar</a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="6" class="sin-datos">Todavia no hay libros registrados.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
