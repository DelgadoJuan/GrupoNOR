<?php
    include_once('Layouts/Tienda/header.php');
    include '..\Util\Config\config.php';
?>
<input type="hidden" id="precioBase" value="<?php echo PRECIO_BASE; ?>">
<input type="hidden" id="precioMayor12" value="<?php echo PRECIO_MAYOR_12; ?>">
<input type="hidden" id="precioMayor15" value="<?php echo PRECIO_MAYOR_15; ?>">

<section>
    <div class="container">
        <h1>Calculadora de Tinglado</h1>
        <form id="tingladoForm">
            <div class="form-group">
                <label for="largo">Largo:</label>
                <input type="number" id="largo" name="largo" class="form-control" required required min="5" max="30">
            </div>
            <div class="form-group">
                <label for="ancho">Ancho:</label>
                <input type="number" id="ancho" name="ancho" class="form-control" required min="5" max="30">
            </div>
            <label for="tipoTecho">Tipo de Techo:</label>
            <select id="tipoTecho" name="tipoTecho">
                <option value="a_dos_aguas">A Dos Aguas</option>
                <option value="plano">Plano</option>
                <option value="parabolico">Parabólico</option>
            </select>
            <label for="color">Color:</label>
            <select id="color" name="color">
                <option value="gris_metalico">Gris Metálico</option>
                <option value="azul">Azul</option>
            </select>
            <div class="form-group">
                <label for="resultado">Precio:</label>
                <div id="resultado" name="resultado" class="mt-3"></div>
            </div>
            <button type="submit" id="addToCart" class="btn btn-primary">Agregar al carrito</button>
        </form>
    </div>
</section>

<?php
    include_once('Layouts/Tienda/footer.php');
?>

<script src="./calculadora.js" type="module"></script>