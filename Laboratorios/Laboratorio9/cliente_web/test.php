<?php
declare(strict_types=1);

$apiBase = 'http://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . '/veterinaria_rest/index.php';
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cliente REST - Veterinaria Patitas</title>
    <style>
        :root {
            color-scheme: light;
            --borde: #d1d5db;
            --fondo: #f8fafc;
            --texto: #111827;
            --principal: #0f766e;
            --principal-oscuro: #115e59;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: var(--fondo);
            color: var(--texto);
            font-family: Arial, sans-serif;
            line-height: 1.5;
            margin: 0;
            padding: 32px;
        }

        main {
            background: #ffffff;
            border: 1px solid var(--borde);
            border-radius: 8px;
            margin: 0 auto;
            max-width: 880px;
            padding: 24px;
        }

        h1 {
            font-size: 28px;
            margin: 0 0 8px;
        }

        form {
            display: grid;
            gap: 16px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            margin-top: 24px;
        }

        label {
            display: grid;
            font-weight: 700;
            gap: 6px;
        }

        input,
        select,
        button,
        pre {
            border-radius: 6px;
            font: inherit;
        }

        input,
        select {
            border: 1px solid var(--borde);
            padding: 10px 12px;
            width: 100%;
        }

        button {
            background: var(--principal);
            border: 0;
            color: #ffffff;
            cursor: pointer;
            font-weight: 700;
            padding: 12px 16px;
        }

        button:hover {
            background: var(--principal-oscuro);
        }

        .fila-completa {
            grid-column: 1 / -1;
        }

        .estado {
            color: #4b5563;
            margin: 8px 0 0;
        }

        pre {
            background: #111827;
            color: #f9fafb;
            min-height: 180px;
            overflow: auto;
            padding: 16px;
            white-space: pre-wrap;
        }

        @media (max-width: 720px) {
            body {
                padding: 16px;
            }

            form {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <main>
        <h1>Cliente web de prueba</h1>
        <p class="estado">API REST: <strong><?= htmlspecialchars($apiBase, ENT_QUOTES, 'UTF-8') ?></strong></p>

        <form id="formPedido">
            <label>
                Cliente
                <input id="cliente" name="cliente" value="Ana Perez" maxlength="100" required>
            </label>

            <label>
                Telefono
                <input id="telefono" name="telefono" value="6000-0000" maxlength="30">
            </label>

            <label>
                Producto
                <select id="producto" name="producto_id" required>
                    <option value="">Cargando productos...</option>
                </select>
            </label>

            <label>
                Cantidad
                <input id="cantidad" name="cantidad" type="number" min="1" value="1" required>
            </label>

            <button class="fila-completa" type="submit">Procesar pedido</button>
        </form>

        <h2>Respuesta</h2>
        <pre id="respuesta">Esperando prueba...</pre>
    </main>

    <script>
        const apiBase = <?= json_encode($apiBase, JSON_UNESCAPED_SLASHES) ?>;
        const formulario = document.querySelector('#formPedido');
        const producto = document.querySelector('#producto');
        const respuesta = document.querySelector('#respuesta');

        async function cargarProductos() {
            try {
                const peticion = await fetch(`${apiBase}/productos`);
                const datos = await peticion.json();
                const productos = datos.productos || [];

                producto.innerHTML = '';

                for (const item of productos) {
                    const opcion = document.createElement('option');
                    opcion.value = item.id;
                    opcion.textContent = `${item.id} - ${item.nombre} ($${Number(item.precio).toFixed(2)}) | stock: ${item.stock}`;
                    producto.appendChild(opcion);
                }

                if (productos.length === 0) {
                    producto.innerHTML = '<option value="">Sin productos disponibles</option>';
                }
            } catch (error) {
                producto.innerHTML = '<option value="">Error al cargar productos</option>';
                respuesta.textContent = error.message;
            }
        }

        formulario.addEventListener('submit', async (evento) => {
            evento.preventDefault();

            const datos = {
                cliente: document.querySelector('#cliente').value,
                telefono: document.querySelector('#telefono').value,
                producto_id: Number(producto.value),
                cantidad: Number(document.querySelector('#cantidad').value),
            };

            try {
                const peticion = await fetch(`${apiBase}/pedidos`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(datos),
                });

                const resultado = await peticion.json();
                respuesta.textContent = JSON.stringify(resultado, null, 2);

                await cargarProductos();
            } catch (error) {
                respuesta.textContent = error.message;
            }
        });

        cargarProductos();
    </script>
</body>
</html>
