<?php foreach ($css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" /> 
<?php endforeach; ?>

<?php foreach ($js_files as $file): ?>
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

<div id="editar">
    <h2>Actualizar Información Personal</h2>
    <?php echo $output; ?>

</div>
