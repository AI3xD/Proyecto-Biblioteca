<?php include 'header.php'; ?>
<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['tipo_usuario'] !== 'Admin') {
    header("Location: ../index.php");
    exit();
}

?>

<h2 style="font-family: 'Lilita One', cursive;">Generación de Reportes</h2>

<div style="background-color: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
    <form id="formReporte">
        <div style="margin-bottom: 1rem;">
            <label for="tipoReporte" style="display: block; margin-bottom: 0.5rem;">Tipo de Reporte:</label>
            <select id="tipoReporte" name="tipoReporte" required style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
                <option value="">Seleccionar tipo de reporte</option>
                <option value="libros">Reporte de Libros</option>
                <option value="usuarios">Reporte de Usuarios</option>
                <option value="prestamos">Reporte de Préstamos</option>
            </select>
        </div>
        <button type="submit" id="btnGenerar" style="background-color: #4CB8B3; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer;">Generar Reporte</button>
    </form>
    <div id="resultadoReporte" style="margin-top: 2rem; display: none;">
        <h3 style="font-family: 'Lilita One', cursive;">Reporte Generado</h3>
        <p id="mensajeReporte"></p>
        <button onclick="descargarReporte()" style="background-color: #F53756; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer; margin-top: 1rem;">Descargar Reporte</button>
    </div>
</div>

<script>
document.getElementById('formReporte').onsubmit = function(e) {
    e.preventDefault();
    var tipoReporte = document.getElementById('tipoReporte').value;
    if (tipoReporte) {
        document.getElementById('btnGenerar').textContent = 'Generando...';
        // Simulamos la generación del reporte
        setTimeout(function() {
            document.getElementById('btnGenerar').textContent = 'Generar Reporte';
            document.getElementById('resultadoReporte').style.display = 'block';
            document.getElementById('mensajeReporte').textContent = 'El reporte de ' + tipoReporte + ' ha sido generado exitosamente.';
        }, 2000);
    } else {
        alert('Por favor, selecciona un tipo de reporte.');
    }
}

function descargarReporte() {
    // Aquí iría la lógica para descargar el reporte
    alert('Descargando reporte...');
}
</script>