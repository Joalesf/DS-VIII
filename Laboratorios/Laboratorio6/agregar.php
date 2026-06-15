<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = $_POST['codigo'] ?? '';
    
    if (!$codigo) {
        echo '<div style="color: red; background-color: #ffebee; padding: 15px; border-radius: 4px;">';
        echo 'El código es requerido.';
        echo '</div>';
        echo '<br><a href="Index.php"><button>Volver</button></a>';
        exit;
    }

    $archivo = 'producto.json';
    
    if (file_exists($archivo)) {
        $productos = json_decode(file_get_contents($archivo), true) ?: [];
        
        if (array_key_exists($codigo, $productos)) {
            echo '<div style="color: red; background-color: #ffebee; padding: 15px; border-radius: 4px;">';
            echo 'El producto con código ' . htmlspecialchars($codigo) . ' ya existe.';
            echo '</div>';
        } else {
            $producto = [
                'codigo' => $codigo,
                'nombre' => $_POST['nombre'] ?? '',
                'marca' => $_POST['marca'] ?? '',
                'precio' => $_POST['precio'] ?? 0,
                'cantidad' => $_POST['cantidad'] ?? 0,
                'categoria' => $_POST['categoria'] ?? ''
            ];
            
            $productos[$codigo] = $producto;
            file_put_contents($archivo, json_encode($productos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            
            echo '<div style="color: green; background-color: #e8f5e9; padding: 15px; border-radius: 4px;">';
            echo '✓ Producto agregado exitosamente.';
            echo '</div>';
        }
    } else {
        $producto = [
            'codigo' => $codigo,
            'nombre' => $_POST['nombre'] ?? '',
            'marca' => $_POST['marca'] ?? '',
            'precio' => $_POST['precio'] ?? 0,
            'cantidad' => $_POST['cantidad'] ?? 0,
            'categoria' => $_POST['categoria'] ?? ''
        ];
        
        $productos = [$codigo => $producto];
        file_put_contents($archivo, json_encode($productos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        
        echo '<div style="color: green; background-color: #e8f5e9; padding: 15px; border-radius: 4px;">';
        echo '✓ Producto agregado exitosamente.';
        echo '</div>';
    }
} else {
    echo '<div style="color: orange; background-color: #fff3e0; padding: 15px; border-radius: 4px;">';
    echo 'Por favor, usa el formulario para agregar un producto.';
    echo '</div>';
}

echo '<br><a href="Index.php"><button>Volver</button></a>';
?>
