<ul>
    <?php
    if (isset($results)) :
        foreach ($results as $data):
            ?>
            <li>
                <?php
                $this->load->view('produccion/item_busqueda', $data);
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
