<a href="/{nombre_controlador}/nuevo">Nuevo</a><br>
<table border="1">
    {cabecera}
    <?php foreach($rows as $row): ?>
    {fila}
    <?php endforeach; ?>
</table>
    <?php echo $paginador; ?>
