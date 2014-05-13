<ul>
    <?php foreach ($results as $data) { ?>
        <li>
            <?php
            $this->load->view('produccion/item_busqueda', $data);
            ?>
        </li>
    <?php } ?>
</ul>

<?php echo $links; ?>
