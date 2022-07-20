<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de Pedidos En Linea - Accesorios Econ&oacute;micos">
    <meta name="author" content="Oscar Fernando Ventura Ortiz">
    <meta name="keywords" content="pedidos, brokers, accesorios economicos, pedidos de accesorios, brokers de accesorios">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="<?= base_url('img/icons/logo-accesorioseconomicos-stroke-85x85.png') ?>" />
    <link rel="canonical" href="<?= current_url() ?>" />

    <title><?= $title; ?> | Sistema de Pedidos</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('js/formvalidation/dist/css/formValidation.min.css') ?>" />
    <link href="<?= base_url('css/light.css') ?>" rel="stylesheet">
</header>
<style>
    @media print {
        #printPageButton {
            display: none;
        }
    }
</style>

<body>
    <main class="content">
        <div class="container-fluid p-0">
            <button id="printPageButton" class="btn btn-primary" onclick="window.print();return false;"><i class="fa-solid fa-print"></i> Imprimir Documento</button>
            <table class="text-center mt-1" style="border: 1px dotted black;">
                <?php
                $datos_x_fila = 3;
                for ($i = 0; $i < 30; $i++) {
                    if ($i == 0) { //primera fila
                        echo "<tr>";
                    }
                    //Rellenamos columnas
                    echo '<td style="border: 1px dotted black; padding: 15px; color:black;"><div class="text-start text-wrap"><b>Producto</b>: ' . $producto['nombre'] . '<br><b>Precio</b>: $' . $producto['precio_venta'] . '</div>' . $codeBar . '<span class="fs-4 fw-bold">' . $producto['sku'] . '</span></td>';
                    if (($i + 1) % $datos_x_fila == 0 && $i > 0) {
                        if ($i == 100) { //última fila
                            echo "</tr>";
                        } else { //quedan más filas
                            echo "</tr><tr>";
                        }
                    }
                    $i + 1;
                }
                ?>
            </table>
        </div>
    </main>
</body>

</html>