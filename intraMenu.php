<!-- Renglones que contienen el menú horizontal para la página web de ITW.MX -->
<td class="tdBarraDarkBlue" width="100%" >
<div id="header">
	<ul class="nav">
		<?php  
			$objOpeDB = new ActionsDB();
			$opMenu = $objOpeDB->getMenus( $PERFIL_USR );
			$idSM = 0;
			If ( !($opMenu <= 0) ) { 
				foreach ( $opMenu as $reg  )  {
					$opSubMenu = $objOpeDB->getSubMenus( $PERFIL_USR , $reg["idMenu"] );
					echo ' <li><a class="'.$reg["icon"].'"> ' .$reg["descripcion"].'</a><ul style="z-index:4;">';
					foreach ( $opSubMenu as $reg  )  {
					//If ( !($opSubMenu <= 0) ) {
					/*echo '<li><a href="'.$reg["href"].'?idMenu='.$reg["idMenu"].' & idSubMenu='.$reg["idSubMenu"].' " >'.$reg["descripcion"].'</a></li>';*/
					echo '<li><a href="'.$reg["href"].'" >'.$reg["descripcion"].'</a></li>';
					}
					echo '</ul>';
					//}
				}
			} 				  
		?> 
	</ul>
</div>
