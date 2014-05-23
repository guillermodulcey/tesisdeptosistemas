<ul>
    <?php
    if (isset($producciones)) :
        foreach ($producciones as $produccion):
            ?>
            <li>
                <?php
                $this->load->view('produccion/item_busqueda', array('produccion'=>$produccion));
                ?>
            </li>
            <?php
        endforeach;
    endif;
    ?>
</ul>

<?php
if (isset($links)) {
    echo $links;
}
