<!-- Renglones que contienen el menú horizontal para la página web de ITW.MX -->
<td class="tdBarraDarkBlue" width="100%" >
<div id="header">
	<ul class="nav">
		<?php  
			$objOpeDB = new ActionsDB();
			$opMenu = $objOpeDB->getMenus( $PERFIL_USR );
			If ( !($opMenu <= 0) ) { 
				foreach ( $opMenu as $reg  )  {
					$opSubMenu = $objOpeDB->getSubMenus( $PERFIL_USR , $reg["idMenu"] );
					echo ' <li><a class="'.$reg["icon"].'"> ' .utf8_decode($reg["descripcion"]).'</a><ul style="z-index:4;">';
					foreach ( $opSubMenu as $key ) {
					echo '<li><a href="'.$key["href"].'" >'.utf8_encode($key["descripcion"]).'</a></li>';
					}
					echo '</ul>';
					//}
				}
			} 				  
		?> 
	</ul>
</div>
