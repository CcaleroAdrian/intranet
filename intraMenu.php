<!-- Renglones que contienen el menú horizontal para la página web de ITW.MX -->
<td class="tdBarraDarkBlue" width="900" height="40">
<div id="header" style="border-bottom-right-radius: 65px; border-bottom-left-radius: 90px;">
	<ul class="nav" >
		<?php  
			$DESCPERFIL_USR;//Descripcion de perfil
			$PERFIL_USR;//ID perfil
			$objOpeDB = new ActionsDB();
			$opMenu = $objOpeDB->getMenus($PERFIL_USR);
			If ( !($opMenu <= 0) ) { 
				foreach ( $opMenu as $reg  )  {
					$opSubMenu = $objOpeDB->getSubMenus( $PERFIL_USR, $reg['menuID']);//cargamos submenus de usuario estandar
					echo ' <li style="padding:10px; style="border-bottom-right-radius: 65px; border-bottom-left-radius: 90px;""><i class="'.$reg["icono"].'"> ' .utf8_decode($reg["descripcion"]).'</i><ul style="z-index:4;">';
					foreach ($opSubMenu as $value) {
					 echo '<li style="border-bottom: 2px solid #bbb;"><a href="'.$value["href"].'" >'.utf8_encode($value["descripcion"]).'</a></li>';
					}
					
					echo '</ul>';
					//}
				}
			} 				  
		?> 
	</ul>
</div>
