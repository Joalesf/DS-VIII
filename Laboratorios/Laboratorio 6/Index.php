<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="Syle.css">
</head>

<body>
    <h1>Gestión de Inventario de Productos</h1>

    <?php
    $productoFile = 'producto.json';
    if (!file_exists($productoFile)) {
        file_put_contents($productoFile, json_encode([]));
    }
    $productos = json_decode(file_get_contents($productoFile), true) ?: [];
    $mensaje = '';
    $tipoMensaje = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $accion = $_POST['accion'] ?? '';
        if ($accion === 'agregar') {
            $codigo = $_POST['codigo'] ?? '';
            if ($codigo && !isset($productos[$codigo])) {
                $productos[$codigo] = [
                    'codigo' => $codigo,
                    'nombre' => $_POST['nombre'] ?? '',
                    'marca' => $_POST['marca'] ?? '',
                    'precio' => $_POST['precio'] ?? 0,
                    'cantidad' => $_POST['cantidad'] ?? 0,
                    'categoria' => $_POST['categoria'] ?? ''
                ];
                file_put_contents($productoFile, json_encode($productos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                $mensaje = '✓ Producto agregado exitosamente';
                $tipoMensaje = 'success';
            } else {
                $mensaje = '✗ El código ya existe o está vacío';
                $tipoMensaje = 'error';
            }
        }

        if ($accion === 'modificar') {
            $codigo = $_POST['codigo'] ?? '';
            if ($codigo && isset($productos[$codigo])) {
                $productos[$codigo] = [
                    'codigo' => $codigo,
                    'nombre' => $_POST['nombre'] ?? '',
                    'marca' => $_POST['marca'] ?? '',
                    'precio' => $_POST['precio'] ?? 0,
                    'cantidad' => $_POST['cantidad'] ?? 0,
                    'categoria' => $_POST['categoria'] ?? ''
                ];
                file_put_contents($productoFile, json_encode($productos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                $mensaje = '✓ Producto modificado exitosamente';
                $tipoMensaje = 'success';
            } else {
                $mensaje = '✗ Producto no encontrado';
                $tipoMensaje = 'error';
            }
        }

        if ($accion === 'eliminar') {
            $codigo = $_POST['codigo'] ?? '';
            if ($codigo && isset($productos[$codigo])) {
                unset($productos[$codigo]);
                file_put_contents($productoFile, json_encode($productos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                $mensaje = '✓ Producto eliminado exitosamente';
                $tipoMensaje = 'success';
            }
        }
    }

    if ($mensaje) {
        echo '<div class="message ' . $tipoMensaje . '">' . $mensaje . '</div>';
    }
    ?>

    <div class="form-section">
        <h2>Agregar Nuevo Producto</h2>
        <form method="post">
            <input type="hidden" name="accion" value="agregar">
            <div>
                <label for="codigo_new">Código (ID):</label>
                <input type="text" id="codigo_new" name="codigo" required>
            </div>
            <div>
                <label for="nombre_new">Nombre:</label>
                <input type="text" id="nombre_new" name="nombre" required>
            </div>
            <div>
                <label for="marca_new">Marca:</label>
                <input type="text" id="marca_new" name="marca" required>
            </div>
            <div>
                <label for="precio_new">Precio:</label>
                <input type="number" id="precio_new" name="precio" step="0.01" required>
            </div>
            <div>
                <label for="cantidad_new">Stock (Cantidad):</label>
                <input type="number" id="cantidad_new" name="cantidad" required>
            </div>
            <div>
                <label for="categoria_new">Tipo de Producto (Categoría):</label>
                <input type="text" id="categoria_new" name="categoria" required>
            </div>
            <button type="submit">Agregar Producto</button>
        </form>
    </div>

    <div>
        <h2>Inventario de Productos</h2>
        <?php if (count($productos) > 0): ?>
            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>Código (ID)</th>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Tipo de Producto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $cod => $prod): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($prod['codigo']); ?></td>
                            <td><?php echo htmlspecialchars($prod['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($prod['marca']); ?></td>
                            <td>$<?php echo htmlspecialchars($prod['precio']); ?></td>
                            <td><?php echo htmlspecialchars($prod['cantidad']); ?></td>
                            <td><?php echo htmlspecialchars($prod['categoria']); ?></td>
                            <td>
                                <button onclick="editarProducto('<?php echo htmlspecialchars($cod); ?>')">Editar</button>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="accion" value="eliminar">
                                    <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($cod); ?>">
                                    <button type="submit" onclick="return confirm('¿Eliminar este producto?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay productos en el inventario.</p>
        <?php endif; ?>
    </div>

    <div class="form-section hidden" id="formularioEdicion">
        <h2>Modificar Producto</h2>
        <form method="post" id="formEditar">
            <input type="hidden" name="accion" value="modificar">
            <div>
                <label for="codigo_edit">Código (ID) - No editable:</label>
                <input type="text" id="codigo_edit" name="codigo" readonly>
            </div>
            <div>
                <label for="nombre_edit">Nombre:</label>
                <input type="text" id="nombre_edit" name="nombre" required>
            </div>
            <div>
                <label for="marca_edit">Marca:</label>
                <input type="text" id="marca_edit" name="marca" required>
            </div>
            <div>
                <label for="precio_edit">Precio:</label>
                <input type="number" id="precio_edit" name="precio" step="0.01" required>
            </div>
            <div>
                <label for="cantidad_edit">Stock (Cantidad):</label>
                <input type="number" id="cantidad_edit" name="cantidad" required>
            </div>
            <div>
                <label for="categoria_edit">Tipo de Producto (Categoría):</label>
                <input type="text" id="categoria_edit" name="categoria" required>
            </div>
            <button type="submit">Guardar Cambios</button>
            <button type="button" onclick="cerrarEdicion()">Cancelar</button>
        </form>
    </div>

    <script>
        const productosData = <?php echo json_encode($productos); ?>;

        function editarProducto(codigo) {
            const producto = productosData[codigo];
            if (producto) {
                document.getElementById('codigo_edit').value = producto.codigo;
                document.getElementById('nombre_edit').value = producto.nombre;
                document.getElementById('marca_edit').value = producto.marca;
                document.getElementById('precio_edit').value = producto.precio;
                document.getElementById('cantidad_edit').value = producto.cantidad;
                document.getElementById('categoria_edit').value = producto.categoria;
                document.getElementById('formularioEdicion').classList.remove('hidden');
                window.scrollTo(0, document.getElementById('formularioEdicion').offsetTop);
            }
        }

        function cerrarEdicion() {
            document.getElementById('formularioEdicion').classList.add('hidden');
        }
    </script>

</body>

</html>