<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = $_POST['codigo'] ?? '';

    if (!file_exists('producto.json')) {
        echo '<div style="color: red; background-color: #ffebee; padding: 15px; border-radius: 4px;">';
        echo 'Archivo de productos no encontrado.';
        echo '</div>';
        echo '<br><a href="Index.php"><button>Volver</button></a>';
        exit;
    }

    $productos = json_decode(file_get_contents('producto.json'), true) ?: [];

    if (array_key_exists($codigo, $productos)) {
        $producto = $productos[$codigo];

        echo '<div style="background-color: #e8f5e9; padding: 15px; border-radius: 4px;">';
        echo '<h2>Producto encontrado:</h2>';
        echo '<p><strong>Código:</strong> ' . htmlspecialchars($producto['codigo']) . '</p>';
        echo '<p><strong>Nombre:</strong> ' . htmlspecialchars($producto['nombre']) . '</p>';
        echo '<p><strong>Marca:</strong> ' . htmlspecialchars($producto['marca']) . '</p>';
        echo '<p><strong>Precio:</strong> $' . htmlspecialchars($producto['precio']) . '</p>';
        echo '<p><strong>Stock:</strong> ' . htmlspecialchars($producto['cantidad']) . '</p>';
        echo '<p><strong>Categoría:</strong> ' . htmlspecialchars($producto['categoria']) . '</p>';
        echo '</div>';
    } else {
        echo '<div style="color: red; background-color: #ffebee; padding: 15px; border-radius: 4px;">';
        echo 'Producto con código ' . htmlspecialchars($codigo) . ' no encontrado.';
        echo '</div>';
    }
} else {
    echo '<div style="color: orange; background-color: #fff3e0; padding: 15px; border-radius: 4px;">';
    echo 'Por favor, usa el formulario para modificar un producto.';
    echo '</div>';
}

echo '<br><a href="Index.php"><button>Volver</button></a>';
