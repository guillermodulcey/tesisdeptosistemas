<?php

/*echo "Tipo monografia: " . $produccion->MONOGRAFIA_TIPO . br() .
 "Autores: " . $produccion->MONOGRAFIA_AUTOR1 . " - " .
 $produccion->MONOGRAFIA_AUTOR2 . br() .
 "Co-Director: " . $produccion->MONOGRAFIA_CODIRECTOR . br();*/
 ?>

<ul id="detallado_monografia">
	<li> <span>Tipo monografia: </span> <?php echo $produccion->MONOGRAFIA_TIPO ?> </li>
	<li> <span>Autores: </span> <?php echo $produccion->MONOGRAFIA_AUTOR1 . " - " .
 $produccion->MONOGRAFIA_AUTOR2 ?> </li>
	<li> <span>Co-Director: </span> <?php echo $produccion->MONOGRAFIA_CODIRECTOR ?> </li>
</ul>