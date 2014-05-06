<ul>
    <?php 
    foreach ($results as $data) { ?>
        <li>
            <?php $this->load->view('producciones/produccion_item', $data); ?>
        </li>
    <?php } ?>
</ul>

<? echo $links; ?>
